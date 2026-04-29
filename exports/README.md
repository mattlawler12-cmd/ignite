# Claude Design Exports — Workspace

This directory is a stable, local-only workspace for unzipping Claude Design HTML/JS/CSS exports so they can be diffed against the live theme in `igniteiq/`. The exports themselves are large and ephemeral — **they are not committed**. Only this `README.md` and `.gitkeep` live here in git.

## Convention

Each new Claude Design export gets unzipped (not committed) into a dated, kebab-case directory:

```
exports/<YYYYMMDD>-<short-name>/
```

Example: `exports/20260501-pricing-update/`

The unzipped contents — including the `site/` subdirectory that Claude Design produces — sit directly under that dated directory. No extra nesting.

## The `latest` symlink

After unzipping a new drop, update the `latest` symlink so tools and skills can target it without knowing the dated name. From inside `exports/`:

```bash
ln -snf <YYYYMMDD>-<short-name> latest
```

This is a symlink, not a copy (Mac-only environment, so no portability concerns). The diff skill resolves `exports/latest` automatically.

## What goes where

- **Inbox** (zips Scott shares): `~/Desktop/screenys/new/` — leave them there, this is not the workspace.
- **Workspace** (unzipped, diff-ready): `exports/` — this directory.

Do not move zips out of the inbox. Unzip them straight into `exports/<dated-dir>/`.

## What is gitignored

The whole `exports/` directory is gitignored except `.gitkeep` and this `README.md`. See the root `.gitignore` for the exact rules. Never commit unzipped contents or the original zips.

## Quick reference: diffing

To diff the latest drop against the previous dated directory:

```
/diff-iiq-export
```

Run with no arguments — it diffs `exports/latest` against the most recent prior dated directory automatically.
