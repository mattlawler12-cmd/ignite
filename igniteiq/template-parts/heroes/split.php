<?php
if (!defined('ABSPATH')) exit;
$eyebrow        = get_sub_field('eyebrow') ?: '';
$headline_lines = get_sub_field('headline_lines') ?: [];
$body           = get_sub_field('body') ?: '';
$primary_cta    = get_sub_field('primary_cta') ?: ['label' => '', 'url' => ''];
$secondary_cta  = get_sub_field('secondary_cta') ?: ['label' => '', 'url' => ''];
$image          = get_sub_field('media_image') ?: null;

if (empty($eyebrow)) {
    $eyebrow = 'Armory v4.2 · Two live deployments';
}
if (empty($headline_lines)) {
    $headline_lines = [
        ['line' => 'Own the system'],
        ['line' => 'that owns your data.'],
    ];
}
if (empty($body)) {
    $body = 'Own your cloud. Own your data. Deploy the ontology that finally makes AI work for the trades.';
}
?>
<section style="position: relative; min-height: calc(100vh - 64px); background: var(--bg-canvas); color: var(--fg-primary); overflow: hidden; border-bottom: 1px solid var(--border-subtle); display: flex; align-items: center;">
  <div style="position: absolute; inset: 0; background-image: linear-gradient(rgba(0,0,0,0.025) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.025) 1px, transparent 1px); background-size: 64px 64px; mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%); -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);"></div>
  <div style="max-width: 1440px; margin: 0 auto; padding: 120px 32px 96px; width: 100%; position: relative; display: grid; grid-template-columns: 1.05fr 0.95fr; gap: 64px; align-items: center;">
    <div>
      <?php if ($eyebrow): ?>
        <span class="iiq-eyebrow" style="font-family: 'Aeonik Fono', monospace; font-size: 11px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--ignite-500); display: inline-flex; align-items: center; gap: 8px;">
          <span style="width:6px;height:6px;border-radius:50%;background:var(--ignite-500);animation: iiqPulse 2s ease-in-out infinite;"></span>
          <?= esc_html($eyebrow) ?>
        </span>
      <?php endif; ?>
      <h1 style="font-family: var(--font-display); font-size: clamp(56px, 8vw, 132px); line-height: 0.92; font-weight: 700; letter-spacing: -0.05em; margin: 24px 0 0; color: var(--fg-primary);">
        <?php foreach ($headline_lines as $row):
          $line = is_array($row) ? ($row['line'] ?? '') : $row;
        ?>
          <span style="display: block;"><?= esc_html($line) ?></span>
        <?php endforeach; ?>
      </h1>
      <?php if ($body): ?>
        <div style="max-width: 560px; font-size: 19px; line-height: 1.5; color: var(--fg-secondary); letter-spacing: -0.005em; margin: 32px 0 0;">
          <?= wp_kses_post($body) ?>
        </div>
      <?php endif; ?>
      <?php $has_primary = !empty($primary_cta['label']); ?>
      <?php $has_secondary = !empty($secondary_cta['label']); ?>
      <?php if ($has_primary || $has_secondary): ?>
        <div style="margin-top: 40px; display: flex; gap: 12px;">
          <?php if ($has_primary): ?>
            <a href="<?= esc_url($primary_cta['url'] ?? '#') ?>" class="iiq-btn" style="font-size: 14px; font-weight: 500; padding: 14px 24px; background: var(--ignite-500); color: #fff; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border-radius: 6px;">
              <?= esc_html($primary_cta['label']) ?> <span>&rarr;</span>
            </a>
          <?php endif; ?>
          <?php if ($has_secondary): ?>
            <a href="<?= esc_url($secondary_cta['url'] ?? '#') ?>" class="iiq-btn-ghost" style="font-size: 14px; font-weight: 500; padding: 14px 24px; background: transparent; color: var(--fg-primary); text-decoration: none; border: 1px solid var(--border-default); border-radius: 6px;">
              <?= esc_html($secondary_cta['label']) ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
    <div style="position: relative; transform: translateX(8%); border-radius: 12px; overflow: hidden; border: 1px solid oklch(22% 0.005 286); box-shadow: 0 60px 120px -40px oklch(7.5% 0.003 286 / 0.45), 0 0 0 1px oklch(22% 0.005 286); background: var(--ink-950);">
      <?php if ($image && !empty($image['ID'])): ?>
        <?= wp_get_attachment_image($image['ID'], 'full', false, ['style' => 'display: block; width: 120%; height: auto;', 'alt' => 'IgniteIQ Armory · Executive Overview']) ?>
      <?php else: ?>
        <img src="<?= esc_url(IIQ_URI . '/assets/img/product-executive-overview.png') ?>" alt="IgniteIQ Armory · Executive Overview" style="display: block; width: 120%; height: auto;">
      <?php endif; ?>
    </div>
  </div>
</section>
