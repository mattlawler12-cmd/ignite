---
name: diff-iiq-export
description: Diff the latest Claude Design export against the live IgniteIQ WP staging site and produce a porting checklist. Use when the user says "diff iiq export", "compare export to staging", "what to change to match the export", or invokes "/diff-iiq-export".
---

# diff-iiq-export

Compare the latest unzipped Claude Design export at `~/Desktop/igniteiq-theme-v2/exports/latest/` against the **live IgniteIQ WP staging site** at `https://igniteiqstg.wpenginepowered.com` and produce a markdown porting checklist. The output tells the porter exactly what content/visuals need to change in `~/Desktop/igniteiq-theme-v2/igniteiq/` (PHP template-parts + `inc/cli.php` seed) to bring staging into byte-equivalent compliance with the export.

**This skill is READ-ONLY.** Never edit PHP, theme files, exports, or staging. Output goes to stdout only.

## Convention

- Exports root: `~/Desktop/igniteiq-theme-v2/exports/`
- Each export: `exports/<YYYYMMDD>-<short-name>/` — Claude Design has shipped two layouts:
  - older: `<dated>/site/{index.html,…}`
  - newer: `<dated>/igniteiq-website/project/{index.html,…}`
  Auto-detect by walking the dated dir until you find an `index.html`. Treat that file's parent as the export content root.
- `exports/latest` is a symlink to the most recent dated dir.
- Live staging base: `https://igniteiqstg.wpenginepowered.com`
- The 6 cornerstone pages (filename → staging path):
  - `index.html` → `/`
  - `how-it-works.html` → `/how-it-works/`
  - `ontology.html` → `/ontology/`
  - `company.html` → `/company/`
  - `contact.html` → `/contact/`
  - `signin.html` → `/signin/`

## Resolving paths

### Default: `/diff-iiq-export` (no args)

```bash
EXPORTS=~/Desktop/igniteiq-theme-v2/exports
NEW_DIR=$(readlink "$EXPORTS/latest")        # e.g. 20260501-pricing-update
NEW_ROOT="$EXPORTS/$NEW_DIR"
# Find the actual content root (handles both old and new Claude Design shapes)
CONTENT=$(find "$NEW_ROOT" -maxdepth 4 -name index.html -print -quit)
CONTENT_DIR=$(dirname "$CONTENT")
STAGING="https://igniteiqstg.wpenginepowered.com"
```

If `latest` is missing, or no `index.html` is found inside it, stop and tell the user: "Drop a Claude Design export into `exports/<YYYYMMDD>-<name>/` and `ln -snf ... latest` first."

### Explicit: `/diff-iiq-export <new-export-path> <old-export-path>`

If the user passes two export paths, fall back to the legacy export-vs-export mode (Section "Legacy mode" at the bottom). This is for "what changed between Scott's two drops" comparisons.

If the user passes one path (`/diff-iiq-export <new-export-path>`), compare that path against staging.

## Step 1 — Page coverage

For each `<filename>.html` directly under `$CONTENT_DIR`:
- If the filename maps to one of the 6 cornerstone pages, mark it `mapped → <staging-path>`.
- Otherwise mark it `unmapped — new page` (porter must seed a new WP page).

Render as:

```
## 1. Page coverage
- index.html → / (mapped)
- how-it-works.html → /how-it-works/ (mapped)
- pricing.html → unmapped (new page — needs `cli.php['pricing']` + WP page row)
```

## Step 2 — Per-page content delta

For each mapped page, fetch the staging HTML and extract the user-visible text from both export and staging. Compare strings.

### Extract visible text

Use the helper script at `~/scripts/igniteiq/iiq-extract.py` (also mirrored in repo at `scripts/iiq-extract.py`). It handles both:
- **Plain HTML** (rendered staging output) — when invoked with stdin, parses tags and emits visible text
- **SPA exports** (Claude Design's React `<div id="root">` shell + `js/*.js` bundle) — when invoked with a directory or a single `.html` path, it walks all `.html` and `.js` files, extracts JS string literals, and applies copy-vs-code heuristics

```bash
EX=/Users/matthewlawler/scripts/igniteiq/iiq-extract.py

# Export side (extracts from HTML + JS bundle in one pass)
python3 "$EX" "$CONTENT_DIR" | LC_ALL=C sort -u > /tmp/iiq.export.txt

# Staging side (curl returns rendered HTML; pipe to script via stdin)
{
  for path in / /how-it-works/ /ontology/ /company/ /contact/ /signin/; do
    curl -sL "$STAGING$path"; echo
  done
} | python3 "$EX" | LC_ALL=C sort -u > /tmp/iiq.staging.txt
```

**Sandbox fallback.** The `curl` loop above is the local fast path. If `curl` returns 0 bytes for every path (Cowork sandbox blocks non-Anthropic outbound), fall back to the `WebFetch` tool: call it with each `https://igniteiqstg.wpenginepowered.com<path>` and the prompt `"Return the verbatim HTML body of this page; do not summarize."`, then concatenate the bodies and pipe through `python3 "$EX"` exactly as before. Treat WebFetch's returned text as if it were curl's stdout. If `WebFetch` is also unavailable, emit: "Cannot reach staging from this environment. Run this skill locally on Matt's Mac, or set up the staging URL in the sandbox allowlist." and stop.

Note: the extractor is heuristic. For SPA exports it filters out CSS values, identifiers, SVG path data, React.createElement code, and template-literal residue. False positives still occur — visual review of short ambiguous strings before treating as porting tasks.

### Compute deltas

For each page, two lists:
- **Missing on staging** (in export, not on staging) — these are the porting tasks.
- **Extra on staging** (on staging, not in export) — usually one of:
  - Genuinely outdated copy that needs to be removed (port action)
  - WP-injected content (admin bar, dynamic nav, footer credits) — note as "ignore"
  - Whitespace/punctuation drift — note as "ignore"

Use `comm -13` and `comm -23` (after sorting) for the set diff. Be tolerant of whitespace normalization (the extractor already collapses) but strict on string content.

Render per page:

````
### / (index.html)

**Missing on staging (porter must add):**
- "Own the engine. Compound the advantage."
- "Local intent translated to operator action."

**Extra on staging (review — remove if outdated):**
- "Own the system that compounds." (likely outdated hero — replace)
- "Skip to content" (WP a11y skip-link — ignore)
````

If a page has zero deltas: `### /<path>/ — ✓ match`.

## Step 3 — WP theme mapping

Build a markdown table of every "missing on staging" string from Step 2, mapped to the template-part and `cli.php` seed row that needs editing.

| Missing string | template-part | cli.php row |
| --- | --- | --- |

### Theme layout reference

- **Heroes:** `igniteiq/template-parts/heroes/{statement,editorial,cinematic,split,minimal}.php`
- **Sections:** `igniteiq/template-parts/sections/{pillars,split,stats,stack,prose,team,trust-logos,trust-quote,cta-banner,diagram,form,contrast}.php`
- **Diagrams:** `igniteiq/template-parts/diagrams/{arch-ontology,boundary,cloud-arch,framework,lattice,operator-stack,platform-stack,stack}.php`
- **Seeded copy:** rows in `IgniteIQ_CLI::default_pages()` in `igniteiq/inc/cli.php`, keyed by page slug: `home`, `how-it-works`, `ontology`, `company`, `contact`, `signin`.

### Mapping heuristics

- HTML/JSX page filename → page slug (`index.html` → `home`, `how-it-works.html` → `how-it-works`, etc.)
- Hero copy (eyebrow + big headline + body) → `heroes/*.php`. Pick by structure (statement = single big headline, editorial = headline + body + image, split = 2-column, cinematic = full-bleed video/image, minimal = small heading only).
- Pillar / feature card array → `sections/pillars.php`, layout `pillars`.
- Numeric/stat block → `sections/stats.php`, layout `stats`.
- Two-column copy/image block → `sections/split.php`, layout `split`.
- Quote / testimonial → `sections/trust-quote.php`, layout `trust_quote`.
- Logo strip → `sections/trust-logos.php`, layout `trust_logos`.
- CTA banner → `sections/cta-banner.php`, layout `cta_banner`.
- Diagram → `sections/diagram.php` + matching `diagrams/*.php` partial.
- Team grid → `sections/team.php`, layout `team`.
- Long-form prose → `sections/prose.php`, layout `prose`.
- Stacked feature list → `sections/stack.php`, layout `stack`.
- Form block → `sections/form.php`, layout `form`.

cli.php row notation: `default_pages()['<slug>'][<index>]` (layout `<layout_key>`). If you don't know the exact index, write `default_pages()['<slug>'][?]` and flag it.

### Unmapped

If a delta can't confidently map to a template-part or cli.php row, list under:

```
### Unmapped — needs manual mapping
- <description>
```

## Step 4 — Visual tokens delta

In the export's HTML, scan `<style>` blocks and inline `style="…"` for color hex codes (`#XXXXXX`), spacing tokens, and any custom CSS variables. Same for staging HTML. List tokens present in export but missing from staging. This is **indicative, not authoritative** — Tailwind's class soup makes byte-perfect class diffs noisy. Visual review is required.

```
## 4. Visual tokens
- Color `#8B5CF6` (in export, not on staging) — destination: `igniteiq/assets/` or hero CSS
- Token `--gap-section: 120px` (was `96px` on staging)
```

## Step 5 — Fidelity checklist

Output a markdown task list the porter ticks off before pushing. Every "missing on staging" content string and visual token gets one line.

```
## 5. Fidelity checklist

### Content (verbatim strings the porter must add to staging)
- [ ] "Own the engine. Compound the advantage." → `igniteiq/template-parts/heroes/statement.php` + `cli.php['home'][0].title`
- [ ] "Local intent translated to operator action." → `igniteiq/template-parts/sections/pillars.php` + `cli.php['home'][1].pillars[?].body`

### Visuals (tokens to apply)
- [ ] `#8B5CF6` accent → `igniteiq/assets/styles.css` or matching template-part CSS
- [ ] `--gap-section: 120px` → confirm in theme stylesheet

### Out-of-scope (porter decides)
- New page `pricing.html` — no `pricing` slug; needs new WP page + `cli.php['pricing']` rows.
- JS animation in `tweaks-panel.js` — decide skip vs. implement.
```

**Be exhaustive, not selective.** List every missing string. Summarizing ("9 testimonials updated") breaks the fidelity contract.

## Output format

```
# Diff: Claude Design export → live staging
Export: <export-dir-name>  ·  Staging: https://igniteiqstg.wpenginepowered.com
Pages: <N> mapped, <M> unmapped  ·  Total missing strings: <K>

## 1. Page coverage
...

## 2. Per-page content delta
### /
...
### /how-it-works/
...

## 3. WP theme mapping
| Missing string | template-part | cli.php row |
| --- | --- | --- |
...
### Unmapped — needs manual mapping
...

## 4. Visual tokens
...

## 5. Fidelity checklist
### Content
- [ ] ...
### Visuals
- [ ] ...
### Out-of-scope
- ...
```

## Reminders

- Quote strings **byte-accurately**. Never paraphrase user-facing copy.
- Be tolerant of whitespace and entity-decoding differences but strict on actual content.
- WP-injected DOM (admin bar, footer credits, skip-links, schema markup) are noise — flag as "ignore" in extras lists, never as porting tasks.
- Do not invent template-part filenames. Only use the layout reference list.
- Do not write to disk. Do not edit any PHP.
- This skill REQUIRES network access (curl to staging). If offline, fail with a clear message.

## Legacy mode (export vs export)

When invoked with two export paths (`/diff-iiq-export <new> <old>`), fall back to the original behavior: file-level diff, per-file component-tree comparison, byte-accurate data-array diffs in fenced ```diff blocks. Useful for "what changed between Scott's last two drops" context. Output structure mirrors the main flow (file changes, per-file deltas, WP mapping, fidelity checklist) but the comparison source is the prior export instead of staging.
