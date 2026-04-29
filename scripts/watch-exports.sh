#!/usr/bin/env bash
# Watcher fired by launchd whenever the Google Drive inbox changes.
# Finds any *.zip not yet processed, waits for sync to complete, validates
# the zip, unzips into exports/<YYYYMMDD>-<derived-name>/, repoints `latest`,
# notifies Matt. Matt then runs `/diff-iiq-export` manually in Claude Code.
#
# Why no auto-diff: the inbox is shared (Scott drops here too). Running
# headless Claude with bypassed permissions on third-party input is too
# risky for what saves ~30s. The watcher does the file plumbing; the diff
# stays under visual review.
#
# Logs to exports/.watcher.log. Idempotent — uses .processed/ markers.

set -uo pipefail

INBOX="$HOME/Google Drive/My Drive/IgniteIQ/Claude Design Exports"
REPO="$HOME/Desktop/igniteiq-theme-v2"
EXPORTS="$REPO/exports"
LOG="$EXPORTS/.watcher.log"
PROCESSED_DIR="$EXPORTS/.processed"

# Safety limits.
MAX_ZIP_BYTES=$((500 * 1024 * 1024))   # 500 MB hard cap on the zip itself
MAX_FILES=20000                         # too many entries → likely zip bomb / not a Claude Design export

mkdir -p "$EXPORTS" "$PROCESSED_DIR"
exec >> "$LOG" 2>&1

ts() { date '+%Y-%m-%d %H:%M:%S'; }
log() { echo "[$(ts)] $*"; }

notify() {
  local title="$1" subtitle="$2" body="$3"
  /usr/bin/osascript -e "display notification \"${body//\"/\\\"}\" with title \"${title//\"/\\\"}\" subtitle \"${subtitle//\"/\\\"}\""
}

log "watcher fired"

shopt -s nullglob
zips=("$INBOX"/*.zip "$INBOX"/*.ZIP)
if [ "${#zips[@]}" -eq 0 ]; then
  log "no zips in inbox; exit"
  exit 0
fi

for zip in "${zips[@]}"; do
  marker="$PROCESSED_DIR/$(basename "$zip").done"
  if [ -f "$marker" ]; then
    continue
  fi

  log "candidate: $zip"

  # Wait for size to stabilize (3 consecutive identical reads, 2s apart).
  # Guards against unzipping a half-synced cloud file.
  prev=-1
  same=0
  for i in $(seq 1 60); do
    cur=$(stat -f%z "$zip" 2>/dev/null || echo -1)
    if [ "$cur" -eq "$prev" ] && [ "$cur" -gt 0 ]; then
      same=$((same + 1))
    else
      same=0
    fi
    if [ "$same" -ge 2 ]; then
      log "size stable at $cur bytes after ${i}s"
      break
    fi
    prev=$cur
    sleep 2
  done

  if [ "$same" -lt 2 ]; then
    log "size never stabilized; skipping (will retry next fire)"
    continue
  fi

  # Derive directory name: <YYYYMMDD>-<kebab-cased-zip-name>.
  base=$(basename "$zip")
  base="${base%.[zZ][iI][pP]}"
  short=$(printf '%s' "$base" | tr '[:upper:]' '[:lower:]' | sed -E 's/[^a-z0-9]+/-/g; s/^-+|-+$//g')
  date_prefix=$(date '+%Y%m%d')
  target="$EXPORTS/${date_prefix}-${short}"

  if [ -e "$target" ]; then
    target="${target}-$(date '+%H%M%S')"
  fi

  # Safety pass: reject suspicious zips before extracting.
  zip_size=$(stat -f%z "$zip")
  if [ "$zip_size" -gt "$MAX_ZIP_BYTES" ]; then
    log "REJECT: zip is $zip_size bytes, exceeds MAX_ZIP_BYTES=$MAX_ZIP_BYTES"
    notify "IgniteIQ export REJECTED" "$(basename "$zip")" "Zip too large — see .watcher.log"
    touch "$marker"
    continue
  fi

  if ! listing=$(unzip -l "$zip" 2>/dev/null); then
    log "REJECT: unzip -l failed (corrupt zip?)"
    notify "IgniteIQ export REJECTED" "$(basename "$zip")" "Corrupt zip — see .watcher.log"
    touch "$marker"
    continue
  fi

  entry_count=$(echo "$listing" | tail -1 | awk '{print $2}')
  if [ -n "$entry_count" ] && [ "$entry_count" -gt "$MAX_FILES" ]; then
    log "REJECT: $entry_count entries exceeds MAX_FILES=$MAX_FILES"
    notify "IgniteIQ export REJECTED" "$(basename "$zip")" "Too many files — see .watcher.log"
    touch "$marker"
    continue
  fi

  # Reject path-traversal entries (../, absolute paths) and symlinks.
  if echo "$listing" | awk 'NR>3 {print $4}' | grep -qE '(^/|\.\./|^\.\./)'; then
    log "REJECT: zip contains path-traversal entries"
    notify "IgniteIQ export REJECTED" "$(basename "$zip")" "Suspicious paths — see .watcher.log"
    touch "$marker"
    continue
  fi
  if unzip -Z1l "$zip" 2>/dev/null | head -200 | xargs -I{} unzip -Zv "$zip" "{}" 2>/dev/null | grep -q "^lrw"; then
    log "REJECT: zip contains symlink entries"
    notify "IgniteIQ export REJECTED" "$(basename "$zip")" "Contains symlinks — see .watcher.log"
    touch "$marker"
    continue
  fi

  log "unzipping → $target"
  mkdir -p "$target"
  if ! unzip -q "$zip" -d "$target"; then
    log "unzip FAILED for $zip"
    rmdir "$target" 2>/dev/null || true
    notify "IgniteIQ export FAILED" "$(basename "$zip")" "Unzip failed — see .watcher.log"
    continue
  fi

  # Repoint latest symlink (relative target keeps it portable).
  cd "$EXPORTS" && ln -snf "$(basename "$target")" latest
  log "latest → $(basename "$target")"

  # Notify Matt to run /diff-iiq-export.
  notify "IgniteIQ export ready" "$(basename "$target")" "Run /diff-iiq-export in Claude Code"

  # Mark zip as processed so we don't redo it on the next watcher fire.
  touch "$marker"
  log "marked processed: $marker"
done

shopt -u nullglob

log "watcher done"
