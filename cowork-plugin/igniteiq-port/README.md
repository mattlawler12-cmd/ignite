# IgniteIQ Port — Cowork plugin

End-to-end Claude Design → WordPress port loop, packaged for the Cowork desktop
app. Drop a Claude Design handoff URL (or attached zip) into a Cowork chat in
the shared **IgniteIQ Website** project; Claude routes through the bundled
skills to fetch the export, diff it against live staging, edit the WP theme
byte-accurately, lint with `php -l`, and stop just before push. You review
the diff and push to `main`. The repo's GitHub Action takes it from there to
WP Engine staging.

This plugin is the multi-user port path. Matt's solo `launchd` watcher
(`scripts/watch-exports.sh` in the repo root) still works for drag-and-drop
into Google Drive. The two paths produce the same `exports/<dated>/` structure
and are interchangeable downstream.

## What's bundled

Five user-scoped skills, all routed via `/<name>`:

- `/fetch-iiq-design` — fetch a Claude Design handoff URL (or ID) into a
  fresh `exports/<dated>-handoff-<id>/`, repoint `exports/latest`, and
  pre-generate `DIFF.md`
- `/diff-iiq-export` — diff `exports/latest/` against live staging and emit a
  porting checklist with WP theme mapping
- `/port-iiq-diff` — edit `cli.php` seed rows + `template-parts/*.php` markup
  to land every "missing on staging" string from the diff; runs `php -l`
- `/verify-iiq-fidelity` — confirm every export string is present on live
  staging (post-deploy fidelity audit)
- `/visual-iiq-diff` — screenshot-based per-page visual gap report
  (export `file://` vs. `https://igniteiqstg.wpenginepowered.com`)

## Install

1. Build the artifact from the repo root:
   ```
   bash scripts/build-cowork-plugin.sh
   ```
   This produces `cowork-plugin/igniteiq-port.plugin`.
2. Open the Cowork desktop app and select the **IgniteIQ Website** project.
3. Drag-drop `igniteiq-port.plugin` onto the chat (or use Cowork's plugin
   install command from the project settings menu — confirm exact path in the
   Cowork docs).

## Connect GitHub (first run)

The skills push edits using whatever GitHub auth Cowork's built-in
connectors provide. The plugin doesn't bundle its own MCP config — Cowork
manages connector lifecycle (auth refresh, scope management) for the whole
project.

1. In Cowork → Settings → Connectors → GitHub, click Connect and complete
   the OAuth flow. Make sure the auth has push access to
   `mattlawler12-cmd/ignite`.
2. Verify the connector shows green before running `/port-iiq-diff`.

## Use

**Handoff URL flow (preferred):**

1. Paste a Claude Design handoff URL into a Cowork chat in the IgniteIQ
   Website project.
2. Claude routes to `/fetch-iiq-design` (downloads the export, unzips into
   `exports/<YYYYMMDD>-<derived-name>/`, repoints `exports/latest`).
3. Claude then runs `/diff-iiq-export` (writes `exports/latest/DIFF.md`)
   and `/port-iiq-diff` (edits `cli.php` + `template-parts/*.php`).
4. Review the diff. When happy, ask Claude to commit + push to `main`. The
   repo's GitHub Action deploys to WPE staging and reseeds.
5. Run `/verify-iiq-fidelity` and `/visual-iiq-diff` to confirm fidelity.

**Attached zip flow:**

Same loop, but skip step 2 — drop the zip into the chat and Claude runs
`/diff-iiq-export` directly against it. *TODO: confirm Cowork's exact
attachment-handling path; the zip needs to land at
`exports/<dated>/` before `/diff-iiq-export` can read it.*

## Don'ts

- **Don't push to production from this plugin.** Staging only. Production is
  a separate manual flow handled outside this repo.
- **Don't bypass the diff.** Always let `/diff-iiq-export` (or the watcher's
  pre-baked `DIFF.md`) drive the port. Manual edits without the diff break
  the fidelity invariant.
- **Don't run `/port-iiq-diff` against `main` without a fresh `exports/latest/`.**
  The skill assumes a current export is on disk.

## Bug reports

File issues at https://github.com/mattlawler12-cmd/ignite/issues. Include
the Cowork session ID, the handoff URL (if applicable), and the relevant
section of `exports/latest/DIFF.md`.
