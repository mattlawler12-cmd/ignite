# IgniteIQ v2 — Activation & Migration Runbook

This is a one-time runbook to switch from the existing v1 theme to v2.

## 0. Default flow (after one-time activation)

For ongoing content updates, you don't need this runbook. The GitHub Action at `.github/workflows/deploy-staging.yml` handles staging on every push to `main`:

1. Edit `template-parts/*.php` and the matching rows in `inc/cli.php` `default_pages()`.
2. Commit + push to `main`.
3. The Action rsyncs `igniteiq/` to `igniteiqstg@igniteiqstg.ssh.wpengine.net:sites/igniteiqstg/wp-content/themes/igniteiq-v2/`, then runs `wp igniteiq seed --force`, then curls all 6 cornerstone URLs to verify 200.
4. Verify at https://igniteiqstg.wpenginepowered.com/.

The runbook below is for **first-time activation** of a fresh WP install (or recovery if the Action is unavailable). On a healthy install, you should never need it.

## 1. Prerequisites

- Local by Flywheel site `igniteiq` running at `http://igniteiq.local/`
- ACF Pro plugin installed and activated
- `bash deploy.sh` has been run from this directory (syncs `igniteiq/` → Local's themes folder as `igniteiq-v2/`)

## 2. Activate v2

1. Open WP Admin → Appearance → Themes
2. Activate **IgniteIQ v2**
3. The existing `igniteiq` (v1) stays installed — you can revert at any time

## 3. WP-CLI migration (recommended)

Open Local → right-click the `igniteiq` site → "Open site shell". Then:

```bash
# Find Architecture page
ARCH_ID=$(wp post list --post_type=page --name=architecture --field=ID)
echo "Architecture page ID: $ARCH_ID"

# Rename Architecture → How it works (preserves the page row)
wp post update $ARCH_ID --post_title="How it works" --post_name="how-it-works"

# Create Contact + Sign in
wp post create --post_type=page --post_status=publish --post_title="Contact" --post_name="contact"
wp post create --post_type=page --post_status=publish --post_title="Sign in" --post_name="signin"

# Set "Home" as the static front page (if not already)
HOME_ID=$(wp post list --post_type=page --name=home --field=ID)
[ -n "$HOME_ID" ] && wp option update show_on_front page && wp option update page_on_front $HOME_ID

# Update Primary menu — replace "Architecture" entry pointing at renamed page
for ID in $(wp menu item list primary --format=ids); do
  TITLE=$(wp post get $ID --field=post_title 2>/dev/null)
  if [ "$TITLE" = "Architecture" ]; then
    wp menu item delete $ID
  fi
done
wp menu item add-post primary $ARCH_ID --title="How it works"

# Flush rewrite rules so /how-it-works/, /contact/, /signin/ resolve
wp rewrite flush --hard

# Seed pages with default flexible-content (idempotent — skips populated pages)
wp igniteiq seed
# Or to overwrite existing data with the JSX defaults:
# wp igniteiq seed --force
```

## 4. Admin UI seed tool (for staging without SSH/WP-CLI)

When SSH/WP-CLI isn't available (e.g. WP Engine staging), use the bundled admin tool:

1. WP Admin → **Tools → IgniteIQ Migrate**
2. Click **Run migration + seed**

This will:
- Create any of the six cornerstone pages that don't yet exist (`home`, `how-it-works`, `ontology`, `company`, `contact`, `signin`)
- Set **Home** as the static front page
- Seed each page's `page_sections` from `inc/cli.php` defaults (skips pages that already have content)

Tick **Force overwrite** to replace existing `page_sections` with the JSX defaults — use this when applying updated seed content from the theme.

The admin tool does **not** rename an existing v1 "Architecture" page or rebuild the Primary menu — for that, use the WP-CLI path in section 3. On a clean staging install with no v1 content, the admin tool is sufficient on its own.

> **Note:** `inc/admin-seed-tool.php` is being removed now that the GitHub Action handles seeding automatically on every push. This section remains as documentation for the legacy admin tool in case it's restored as an emergency fallback. Do not extend or depend on it.

## 5. UI equivalent (manual click-path)

If neither WP-CLI nor the admin seed tool fits:

1. **Pages → Architecture → Quick Edit**
   - Title: `How it works`
   - Slug: `how-it-works`
   - Update
2. **Pages → Add New** twice — create:
   - "Contact" (slug `contact`)
   - "Sign in" (slug `signin`)
3. **Settings → Reading**: ensure "A static page" is selected, with "Home" as front page
4. **Appearance → Menus → Primary**:
   - Remove the "Architecture" item
   - Add the renamed page (now titled "How it works") to the menu
5. **Settings → Permalinks → Save Changes** (no edits needed — just press Save to flush rewrites)
6. Edit each page in WP Admin and fill in the ACF Page Sections fields. Or run `wp igniteiq seed` from Local's site shell to populate defaults.

## 6. Verification

```bash
# In Local site shell:
for url in / /how-it-works/ /ontology/ /company/ /contact/ /signin/; do
  echo -n "$url -> "
  curl -o /dev/null -s -w "%{http_code}\n" "http://igniteiq.local${url}"
done
```

All should return `200`. Old slug `/architecture/` should auto-301 to `/how-it-works/` via WP's `wp_old_slug_redirect`.

Visual checks:
- Home: hero, all numbered sections, footer render
- Mobile (DevTools at 859px): burger appears, opens drawer, ESC closes, scroll locked while open
- Contact form: fill required fields, submit, see success state. Check Local's Mailpit/Mailhog tab for the outbound email.
- Honeypot: in DevTools, find the hidden `<input name="website">`, fill it, submit — request silently accepted with no email sent.
- Console: no errors on any page
- On WP Engine staging, the deploy Action's final step runs the same curl-loop against `https://igniteiqstg.wpenginepowered.com/`. Check the Actions log for the per-URL status.

## 7. Editing copy

In WP Admin → edit any of the 6 pages. The page editor is **disabled** for these pages (the_content() is bypassed). Instead, scroll to the **Page Sections** ACF flexible-content field and edit the layouts there.

Layouts available (15 total):
- 5 hero variants — statement, editorial, cinematic, split, minimal
- 6 section types — pillars, split, stats, stack, prose, team
- 3 trust + CTA — trust-logos, trust-quote, cta-banner
- 2 utility — diagram, form

Site-wide content (footer columns, contact email, social links) lives in **Site Settings** in the admin sidebar.

## 8. Reverting

If anything breaks: WP Admin → Appearance → Themes → activate `igniteiq` (v1). The v1 theme is still installed.
