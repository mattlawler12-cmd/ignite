# AGENTS.md

Operating notes for LLM agents working in this repo. Read this first.

## 1. What this repo is

WordPress theme for **igniteiq.com**, ported from Claude Design HTML/JS/CSS exports. This repo is the canonical source of truth — the theme code lives in `igniteiq/`, with the repo root holding deploy tooling and runbooks. There are two deploy paths: **Local by Flywheel** for visual dev, and **WP Engine staging** via a GitHub Action on push to `main`. Production is not automated.

## 2. Theme directory layout

```
igniteiq/
  functions.php          - bootstrap; require_once chain for inc/*
  style.css              - WP theme header
  header.php / footer.php / 404.php / index.php / page.php
  front-page.php         - entry for the home page
  page-how-it-works.php  - per-template entry
  page-ontology.php
  page-company.php
  page-contact.php
  page-signin.php
  template-parts/
    nav.php / footer.php
    heroes/              - 5 hero variants
      statement.php editorial.php cinematic.php split.php minimal.php
    sections/            - reusable sections + helpers
      pillars.php split.php stats.php stack.php prose.php team.php
      contrast.php trust-logos.php trust-quote.php cta-banner.php
      diagram.php form.php _helpers.php
    diagrams/            - SVG/PHP diagrams referenced from sections
      arch-ontology.php boundary.php cloud-arch.php framework.php
      lattice.php operator-stack.php platform-stack.php stack.php
    forms/
      contact.php signin.php
  inc/
    theme-setup.php       - theme support, image sizes
    enqueue.php           - styles + scripts
    nav-menus.php         - menu locations
    acf-field-groups.php  - ACF flexible-content layout definitions
    acf-options-page.php  - site-wide settings (Site Settings)
    acf-render-flexible.php - the_flexible_field loop renderer
    contact-form.php      - contact form handler + honeypot
    cli.php               - WP-CLI `wp igniteiq seed` + IgniteIQ_CLI::default_pages()
    admin-seed-tool.php   - DEPRECATED, being removed (do not extend)
  assets/                 - CSS/JS/images/fonts
```

Repo root (outside `igniteiq/`):

```
deploy.sh                       - rsync to Local Sites theme dir
README.md / MIGRATE.md          - human runbooks
.github/workflows/
  deploy-staging.yml            - WPE staging deploy on push to main
exports/                        - gitignored Claude Design export workspace
  README.md / .gitkeep
```

## 3. ACF flexible-content pattern (load-bearing)

This is the spine of the site. Internalize it before editing.

- Each of the **6 cornerstone pages** (`home`, `how-it-works`, `ontology`, `company`, `contact`, `signin`) has an ACF flexible-content field named `page_sections`.
- The 15 layouts are registered in `igniteiq/inc/acf-field-groups.php`: 5 heroes + 6 section types (pillars, split, stats, stack, prose, team) + trust-logos + trust-quote + cta-banner + diagram + form.
- Each layout's PHP renderer lives at `igniteiq/template-parts/{heroes,sections,diagrams,forms}/<name>.php`.
- `igniteiq/inc/acf-render-flexible.php` is the loop that walks `page_sections` and dispatches to each renderer in order. Page templates (`front-page.php`, `page-*.php`) call into this — `the_content()` is bypassed.
- **Default content** for each page is seeded by `IgniteIQ_CLI::default_pages()` in `igniteiq/inc/cli.php`, keyed by page slug. The class is defined unconditionally so non-CLI callers (e.g. the deprecated admin tool) can read the defaults.
- To add or change copy on a cornerstone page: edit the renderer (PHP markup) **and** the matching seed row (PHP array in `default_pages()`) in lockstep. Markup-only changes leave the DB stale; seed-only changes have no place to render.
- Site-wide content (footer columns, contact email, social links) lives in the ACF options page registered by `inc/acf-options-page.php` ("Site Settings" in the admin sidebar), not in `page_sections`.

## 4. Two deploy paths

**Local visual dev** (manual, fast iteration):
- `bash deploy.sh` from repo root.
- rsyncs `igniteiq/` → `~/Local Sites/igniteiq/app/public/wp-content/themes/igniteiq-v2/` (with `--delete`, excluding `.git`, `.DS_Store`, `node_modules`, `deploy.sh`).
- Visit `http://igniteiq.local/`. ACF Pro must be installed in the Local site. Seed via `wp igniteiq seed --force` from Local's site shell when copy changes.

**WP Engine staging** (automated, on push to `main`):
- Triggered by `.github/workflows/deploy-staging.yml` (also `workflow_dispatch`).
- Steps: load `WPE_SSH_KEY` secret → rsync `igniteiq/` → `igniteiqstg@igniteiqstg.ssh.wpengine.net:sites/igniteiqstg/wp-content/themes/igniteiq-v2/` (excluding `.git`, `*.bak*`, `node_modules`, `exports/`) → SSH in and run `wp igniteiq seed --force` → curl-verify the 6 cornerstone URLs return 200.
- Watch deploys at the GitHub Actions tab. Live preview at `https://igniteiqstg.wpenginepowered.com/`.
- Concurrency group `deploy-staging` prevents overlapping runs; new pushes queue rather than cancel.

**Production** is not automated. Pushing to `main` does **not** touch production. Production deploy is a separate manual step (out of scope for this repo).

## 5. Export-drop convention

See `exports/README.md` for full details. Quick version:

- Inbox for new Claude Design zips Scott shares: `~/Desktop/screenys/new/` (leave them there).
- Workspace: unzip into `exports/<YYYYMMDD>-<short-name>/` (e.g. `exports/20260501-pricing-update/`). No extra nesting — the export's `site/` subdir sits directly under the dated dir.
- Update the `latest` symlink after each drop: `cd exports && ln -snf <YYYYMMDD>-<short-name> latest`.
- Everything under `exports/` is gitignored except `.gitkeep` and `README.md`. Never commit unzipped contents or zips.

## 6. Port process (the loop)

1. New export drops at `~/Desktop/screenys/new/`. Unzip into `exports/<YYYYMMDD>-<short-name>/` and update the `latest` symlink: `cd exports && ln -snf <YYYYMMDD>-<short-name> latest`.
2. Run `/diff-iiq-export` (skill at `~/.claude/skills/diff-iiq-export/`). It diffs `exports/latest` against the previous dated dir. Read the markdown delta report — focus on the WP-mapping table at the bottom.
3. Edit the listed `igniteiq/template-parts/*.php` files (markup) **and** the matching rows in `igniteiq/inc/cli.php` `default_pages()` (seeded copy). Keep them in sync.
4. `bash deploy.sh` to mirror to Local. Preview at `http://igniteiq.local/`. Reseed in Local's site shell if copy changed: `wp igniteiq seed --force`.
5. Commit + push to `main`. The Action deploys to WPE staging and reseeds automatically. Verify at `https://igniteiqstg.wpenginepowered.com/`.

## 7. Don'ts

- Don't add new code to `igniteiq/inc/admin-seed-tool.php`. It's a temporary bridge for staging without SSH/WP-CLI and is being removed once staging is happy. Use WP-CLI (`wp igniteiq seed`) or the GitHub Action seed step instead.
- Don't bypass `IgniteIQ_CLI::default_pages()` in `igniteiq/inc/cli.php` for seed copy. It's the single source of truth, paired with `template-parts/` markup. Don't hardcode copy in renderers as fallbacks for missing seed data.
- Don't edit ACF field groups in WP Admin — they're PHP-registered in `inc/acf-field-groups.php` (no `acf-json/` sync), so admin edits are non-persistent and lost on next deploy.
- Don't edit theme files inside `~/Local Sites/.../themes/igniteiq-v2/` directly. That directory is a runtime mirror and is overwritten by the next `bash deploy.sh`. Edit here, then deploy.
- Don't commit anything under `exports/` (it's gitignored, but be aware — large unzipped trees should never make it into git).
- Don't deploy to production from this repo. Staging only. Production is a separate manual flow.
- Don't skip the seed step after pushing copy changes — the Action handles WPE staging, but Local needs `wp igniteiq seed --force` run by hand from the site shell.

Last updated: 2026-04-29
