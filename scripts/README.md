# scripts/

Shell tooling that supports the export → port loop. The canonical copy of the watcher
also lives outside `~/Desktop/` (at `~/scripts/igniteiq/watch-exports.sh`) because
macOS TCC blocks `launchd`-spawned processes from reading anything under `~/Desktop/`.
This in-repo copy is the source of truth — keep them in sync if you edit it.

## watch-exports.sh

Triggered by a `launchd` agent whenever the shared Google Drive inbox changes.
Drop a zip into the inbox; ~30 seconds later the export is unzipped into
`exports/<YYYYMMDD>-<derived-name>/`, the `latest` symlink is repointed, and a
macOS notification fires telling Matt to run `/diff-iiq-export`.

### What it does
1. Polls every detected zip's size until 3 reads in a row are identical (guards
   against unzipping a file that's still mid-sync from cloud).
2. Validates the zip: ≤ 500 MB, ≤ 20 000 entries, no path-traversal entries,
   no symlink entries.
3. Unzips into `exports/<YYYYMMDD>-<kebab-cased-name>/`.
4. Repoints `exports/latest` (relative symlink).
5. Sends a macOS notification.
6. Marks the zip as processed in `exports/.processed/`.

### What it does NOT do
- Does **not** run `/diff-iiq-export` automatically. The inbox is shared with
  Scott; running headless Claude with bypassed permissions on third-party input
  is too risky. Matt runs the slash command manually after seeing the notification.
- Does not commit, push, or touch any PHP file.

### Logs
Per-fire log at `exports/.watcher.log`. Stdout/stderr from launchd at
`/tmp/igniteiq-export-watcher.{out,err}`.

## One-time setup

```bash
# 1. Copy the canonical script outside ~/Desktop/ (TCC requires this)
mkdir -p ~/scripts/igniteiq
cp ~/Desktop/igniteiq-theme-v2/scripts/watch-exports.sh ~/scripts/igniteiq/
chmod +x ~/scripts/igniteiq/watch-exports.sh

# 2. Install the launchd plist
cp ~/Desktop/igniteiq-theme-v2/scripts/com.igniteiq.export-watcher.plist \
   ~/Library/LaunchAgents/

# 3. Load it
launchctl bootstrap "gui/$(id -u)" \
  ~/Library/LaunchAgents/com.igniteiq.export-watcher.plist

# 4. Grant Full Disk Access to /bin/bash (REQUIRED — see below)
```

## Granting Full Disk Access

`launchd` agents run in a sandbox that can't read `~/Desktop/` or
`~/Library/CloudStorage/` (Google Drive) without TCC permission. Without this,
the watcher fires but always logs "no zips in inbox".

1. Open **System Settings → Privacy & Security → Full Disk Access**
2. Click **+**
3. Press **⌘⇧G** and type `/bin/bash`, click "Choose"
4. Make sure the toggle next to **bash** is **on**
5. Reload the agent:
   ```bash
   launchctl kickstart -k "gui/$(id -u)/com.igniteiq.export-watcher"
   ```

After this, any zip dropped into the Google Drive inbox auto-processes.

## Troubleshooting

```bash
# Is the agent loaded?
launchctl list | grep igniteiq

# Force a fire (test path, not the watcher)
~/scripts/igniteiq/watch-exports.sh

# Force a fire (via launchd, tests TCC + plist together)
launchctl kickstart -k "gui/$(id -u)/com.igniteiq.export-watcher"

# Tail the watcher log
tail -f ~/Desktop/igniteiq-theme-v2/exports/.watcher.log

# Reset processed markers (re-process a previously-handled zip)
rm ~/Desktop/igniteiq-theme-v2/exports/.processed/<zip-name>.zip.done

# Unload the agent (stop watching)
launchctl bootout "gui/$(id -u)/com.igniteiq.export-watcher"
```

## The plist

`com.igniteiq.export-watcher.plist` is a copy of what's installed at
`~/Library/LaunchAgents/`. Keep them in sync if you edit either.
