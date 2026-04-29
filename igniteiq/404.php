<?php
if (!defined('ABSPATH')) exit;
get_header();
?>
<section class="iiq-pad iiq-section-pad" style="min-height:60vh;display:grid;place-items:center;text-align:center;padding-top:200px;">
  <div>
    <span style="font-family:'Aeonik Fono',monospace;font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:var(--fg-tertiary);">404</span>
    <h1 class="iiq-display-lg" style="margin:16px 0 12px;">Not found.</h1>
    <p style="color:var(--fg-secondary);margin:0 0 32px;">The page you're looking for doesn't exist.</p>
    <a href="<?= esc_url(home_url('/')) ?>" class="iiq-btn">Back home</a>
  </div>
</section>
<?php
get_footer();
