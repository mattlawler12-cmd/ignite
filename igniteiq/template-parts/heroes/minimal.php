<?php
if (!defined('ABSPATH')) exit;
$eyebrow        = get_sub_field('eyebrow') ?: '';
$headline_lines = get_sub_field('headline_lines') ?: [];
$body           = get_sub_field('body') ?: '';
$primary_cta    = get_sub_field('primary_cta') ?: ['label' => '', 'url' => ''];
$secondary_cta  = get_sub_field('secondary_cta') ?: ['label' => '', 'url' => ''];

if (empty($headline_lines)) {
    $headline_lines = [
        ['line' => 'Get in touch.'],
    ];
}
$total_lines = count($headline_lines);
?>
<section style="position: relative; background: var(--bg-canvas); color: var(--fg-primary); border-bottom: 1px solid var(--border-subtle); overflow: hidden;">
  <div style="max-width: 1440px; margin: 0 auto; padding: 120px 32px; width: 100%; position: relative;">
    <?php if ($eyebrow): ?>
      <span class="iiq-eyebrow" style="font-family: 'Aeonik Fono', monospace; font-size: 11px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--ignite-500); display: inline-flex; align-items: center; gap: 8px;">
        <span style="width:6px;height:6px;border-radius:50%;background:var(--ignite-500);animation: iiqPulse 2s ease-in-out infinite;"></span>
        <?= esc_html($eyebrow) ?>
      </span>
    <?php endif; ?>
    <h1 style="font-family: var(--font-display); font-size: clamp(44px, 5.2vw, 88px); line-height: 1.06; font-weight: 600; letter-spacing: -0.04em; margin: 40px 0 0; color: var(--fg-primary); max-width: 1240px; text-wrap: balance;">
      <?php foreach ($headline_lines as $i => $row):
        $line = is_array($row) ? ($row['line'] ?? '') : $row;
        $is_last = ($i === $total_lines - 1);
        $is_muted = (!$is_last && $total_lines > 1);
        $color = $is_muted ? 'var(--fg-tertiary)' : 'var(--fg-primary)';
      ?>
        <span style="display: block; color: <?= $color ?>;"><?= esc_html($line) ?></span>
      <?php endforeach; ?>
    </h1>
    <?php if ($body): ?>
      <div style="max-width: 640px; font-size: 19px; line-height: 1.55; color: var(--fg-secondary); letter-spacing: -0.005em; margin: 24px 0 0;">
        <?= wp_kses_post($body) ?>
      </div>
    <?php endif; ?>
    <?php $has_primary = !empty($primary_cta['label']); ?>
    <?php $has_secondary = !empty($secondary_cta['label']); ?>
    <?php if ($has_primary || $has_secondary): ?>
      <div style="margin-top: 32px; display: flex; gap: 12px;">
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
</section>
