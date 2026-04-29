#!/usr/bin/env bash
# Sync canonical theme → Local Sites theme directory.
# Run from the directory containing this script.
set -euo pipefail

SRC="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/igniteiq/"
DEST="/Users/matthewlawler/Local Sites/igniteiq/app/public/wp-content/themes/igniteiq-v2/"

if [ ! -d "$SRC" ]; then
  echo "Source not found: $SRC"; exit 1
fi

mkdir -p "$DEST"

rsync -av --delete \
  --exclude='.git' \
  --exclude='.DS_Store' \
  --exclude='node_modules' \
  --exclude='deploy.sh' \
  "$SRC" "$DEST"

echo
echo "Synced: $SRC → $DEST"
echo
echo "Next steps:"
echo "  1. WP Admin → Appearance → Themes → activate 'IgniteIQ v2'"
echo "  2. Make sure ACF Pro is installed + active"
echo "  3. Run: bash MIGRATE.sh   (or follow MIGRATE.md manually)"
