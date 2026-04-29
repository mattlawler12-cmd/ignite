<?php
/** Template Name: Sign in */
if (!defined('ABSPATH')) exit;

/**
 * Sign-in page template.
 *
 * Renders the global IgniteIQ nav (header.php → template-parts/nav.php — this
 * is where the logo lives, top-left), then the full-viewport split-screen
 * sign-in panel from template-parts/forms/signin.php.
 *
 * The export (exports/latest/signin.html) is a self-contained full-viewport
 * page with NO global site footer. We deliberately bypass get_footer() here
 * so the marketing footer does not leak below the sign-in panel.
 *
 * The split-screen wrapper enforces min-height:100vh so the dark aside fills
 * the viewport even when the nav (~70px) consumes the top edge.
 */

get_header();
?>
<div class="iiq-signin-page" style="min-height:100vh;background:var(--bg-canvas,#fff);">
  <?php get_template_part('template-parts/forms/signin'); ?>
</div>
<?php
// FIDELITY EXCEPTION: export has no global footer; sign-in is full-viewport.
// We intentionally skip get_footer() here. wp_footer() still fires for
// scripts/admin-bar/etc.
wp_footer();
?>
</body>
</html>
