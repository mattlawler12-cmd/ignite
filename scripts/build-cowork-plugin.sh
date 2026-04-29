#!/usr/bin/env bash
# build-cowork-plugin.sh
#
# Build the IgniteIQ Port Cowork plugin artifact:
#   cowork-plugin/igniteiq-port.plugin
#
# Steps:
#   1. Refresh user-scoped skills from ~/.claude/skills/ into the plugin tree
#   2. Validate plugin.json + .mcp.json parse as JSON
#   3. Lint each SKILL.md has YAML frontmatter (---, name:, description:)
#   4. Zip the plugin dir contents into cowork-plugin/igniteiq-port.plugin
#   5. Print size + unzip listing
#
# Usage:
#   bash scripts/build-cowork-plugin.sh           # one-shot build
#   bash scripts/build-cowork-plugin.sh --watch   # rebuild on SKILL.md changes (requires fswatch)

set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PLUGIN_DIR="$REPO_ROOT/cowork-plugin/igniteiq-port"
ARTIFACT="$REPO_ROOT/cowork-plugin/igniteiq-port.plugin"
SKILLS_SRC="$HOME/.claude/skills"
SKILLS_DST="$PLUGIN_DIR/skills"
SKILL_NAMES=(
  fetch-iiq-design
  diff-iiq-export
  port-iiq-diff
  verify-iiq-fidelity
  visual-iiq-diff
)

color() { printf "\033[%sm%s\033[0m\n" "$1" "$2"; }
info() { color "0;36" "[info] $*"; }
warn() { color "1;33" "[warn] $*"; }
err()  { color "1;31" "[err]  $*"; }
ok()   { color "0;32" "[ok]   $*"; }

build_once() {
  info "repo root:  $REPO_ROOT"
  info "plugin dir: $PLUGIN_DIR"

  if [[ ! -d "$PLUGIN_DIR/.claude-plugin" ]]; then
    err ".claude-plugin/ missing under $PLUGIN_DIR — scaffold not created. Aborting."
    exit 1
  fi

  # 1. Refresh skills
  mkdir -p "$SKILLS_DST"
  local copied=0 missing=()
  for s in "${SKILL_NAMES[@]}"; do
    local src="$SKILLS_SRC/$s"
    local dst="$SKILLS_DST/$s"

    if [[ ! -d "$src" ]] || [[ ! -f "$src/SKILL.md" ]]; then
      warn "skill not found: $src (will skip — likely still being built)"
      missing+=("$s")
      continue
    fi

    rm -rf "$dst"
    cp -R "$src" "$dst"
    copied=$((copied + 1))
    ok "refreshed skill: $s"
  done

  if (( ${#missing[@]} > 0 )); then
    warn "missing skills (plugin will ship without them): ${missing[*]}"
  fi
  info "copied $copied / ${#SKILL_NAMES[@]} skills"

  # 2. Validate JSON
  validate_json() {
    local file="$1"
    if [[ ! -f "$file" ]]; then
      err "$file not found"; exit 1
    fi
    if command -v jq >/dev/null 2>&1; then
      jq empty "$file" >/dev/null
    else
      python3 -m json.tool "$file" >/dev/null
    fi
    ok "valid JSON: $(basename "$file")"
  }
  validate_json "$PLUGIN_DIR/.claude-plugin/plugin.json"
  validate_json "$PLUGIN_DIR/.mcp.json"

  # 3. Lint each SKILL.md frontmatter
  local lint_errs=0
  while IFS= read -r -d '' skill_md; do
    # Must start with --- on line 1, contain name: and description: in the frontmatter block
    local first_line
    first_line=$(head -n 1 "$skill_md")
    if [[ "$first_line" != "---" ]]; then
      err "missing YAML frontmatter opener (---) in $skill_md"
      lint_errs=$((lint_errs + 1))
      continue
    fi
    # Pull frontmatter block: lines 2..(next ---)
    local fm
    fm=$(awk 'NR==1 && $0=="---"{flag=1;next} flag && $0=="---"{exit} flag{print}' "$skill_md")
    if ! grep -qE '^name:[[:space:]]+' <<<"$fm"; then
      err "missing 'name:' in frontmatter: $skill_md"
      lint_errs=$((lint_errs + 1))
    fi
    if ! grep -qE '^description:[[:space:]]+' <<<"$fm"; then
      err "missing 'description:' in frontmatter: $skill_md"
      lint_errs=$((lint_errs + 1))
    fi
    if (( lint_errs == 0 )); then
      ok "frontmatter valid: $(basename "$(dirname "$skill_md")")/SKILL.md"
    fi
  done < <(find "$SKILLS_DST" -mindepth 2 -maxdepth 2 -name SKILL.md -print0)

  if (( lint_errs > 0 )); then
    err "$lint_errs SKILL.md lint failure(s) — aborting"
    exit 1
  fi

  # 4. Zip
  rm -f "$ARTIFACT"
  ( cd "$PLUGIN_DIR" && zip -qr "$ARTIFACT" . -x "*.DS_Store" )
  ok "wrote $ARTIFACT"

  # 5. Print size + listing
  local size
  size=$(du -h "$ARTIFACT" | awk '{print $1}')
  info "size: $size"
  info "contents:"
  unzip -l "$ARTIFACT"
}

watch_loop() {
  if ! command -v fswatch >/dev/null 2>&1; then
    err "fswatch not found. Install with: brew install fswatch"
    exit 1
  fi
  info "watching $SKILLS_SRC for SKILL.md changes (Ctrl-C to stop)"
  build_once
  fswatch -o \
    "$SKILLS_SRC/fetch-iiq-design" \
    "$SKILLS_SRC/diff-iiq-export" \
    "$SKILLS_SRC/port-iiq-diff" \
    "$SKILLS_SRC/verify-iiq-fidelity" \
    "$SKILLS_SRC/visual-iiq-diff" 2>/dev/null \
    | while read -r _; do
        info "change detected — rebuilding"
        build_once || warn "build failed; will retry on next change"
      done
}

case "${1:-}" in
  --watch) watch_loop ;;
  ""|--once) build_once ;;
  *)
    err "unknown arg: $1"
    echo "usage: $0 [--once|--watch]" >&2
    exit 2
    ;;
esac
