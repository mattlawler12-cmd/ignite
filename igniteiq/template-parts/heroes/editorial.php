<?php
if (!defined('ABSPATH')) exit;
$eyebrow        = get_sub_field('eyebrow') ?: '';
$headline_lines = get_sub_field('headline_lines') ?: [];
$body           = get_sub_field('body') ?: '';
$primary_cta    = get_sub_field('primary_cta') ?: ['label' => '', 'url' => ''];
$secondary_cta  = get_sub_field('secondary_cta') ?: ['label' => '', 'url' => ''];
$dark           = get_sub_field('dark') ? true : false;

// Fallback default headline lines (from JSX defaults)
if (empty($headline_lines)) {
    $headline_lines = [
        ['line' => 'Own your intelligence.'],
        ['line' => 'Own your future.'],
    ];
}

// Compute headline length for sizing parity with JSX
$headline_concat = '';
foreach ($headline_lines as $row) {
    $headline_concat .= (is_array($row) ? ($row['line'] ?? '') : $row) . "\n";
}
$is_long = strlen($headline_concat) > 80;
$h1_font_size      = $is_long ? 'clamp(36px, 4.6vw, 72px)' : 'clamp(64px, 11vw, 184px)';
$h1_line_height    = $is_long ? '1.04' : '0.92';
$h1_font_weight    = $is_long ? '600' : '700';

$total_lines = count($headline_lines);
?>
<section style="position: relative; min-height: calc(100vh - 64px); background: <?= $dark ? 'var(--ink-1000)' : 'var(--bg-canvas)' ?>; color: <?= $dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>; overflow: hidden; border-bottom: <?= $dark ? '1px solid oklch(20% 0.005 286)' : '1px solid var(--border-subtle)' ?>; display: flex; align-items: center;">
  <div style="max-width: 1440px; margin: 0 auto; padding: 96px 32px; width: 100%; position: relative;">
    <?php if ($eyebrow): ?>
      <span class="iiq-eyebrow" style="font-family: 'Aeonik Fono', monospace; font-size: 11px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--ignite-500); display: inline-flex; align-items: center; gap: 8px;">
        <span style="width:6px;height:6px;border-radius:50%;background:var(--ignite-500);animation: iiqPulse 2s ease-in-out infinite;"></span>
        <?= esc_html($eyebrow) ?>
      </span>
    <?php endif; ?>
    <h1 style="font-family: var(--font-display); font-size: <?= $h1_font_size ?>; line-height: <?= $h1_line_height ?>; font-weight: <?= $h1_font_weight ?>; letter-spacing: -0.04em; margin: 32px 0 0; color: <?= $dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>; max-width: 1400px;">
      <?php foreach ($headline_lines as $i => $row):
        $line  = is_array($row) ? ($row['line'] ?? '') : $row;
        $is_last = ($i === $total_lines - 1);
        $is_muted = (!$is_last && $total_lines > 1);
        $color = $is_muted
          ? ($dark ? 'oklch(60% 0.005 286)' : 'var(--fg-tertiary)')
          : ($dark ? 'var(--ink-50)' : 'var(--fg-primary)');
      ?>
        <span style="display: block; color: <?= $color ?>; opacity: 1;"><?= esc_html($line) ?></span>
      <?php endforeach; ?>
    </h1>
    <div style="margin-top: 64px; display: grid; grid-template-columns: 1fr auto; gap: 64px; align-items: flex-end;">
      <?php if ($body): ?>
        <div style="max-width: 640px; font-size: 19px; line-height: 1.55; color: <?= $dark ? 'oklch(75% 0.005 286)' : 'var(--fg-secondary)' ?>; letter-spacing: -0.005em; margin: 0;">
          <?= wp_kses_post($body) ?>
        </div>
      <?php else: ?>
        <div></div>
      <?php endif; ?>
      <div style="display: flex; gap: 12px;">
        <?php if (!empty($primary_cta['url'])): ?>
          <a href="<?= esc_url($primary_cta['url']) ?>" class="iiq-btn" style="font-size: 14px; font-weight: 500; padding: 14px 24px; background: var(--ignite-500); color: #fff; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border-radius: 6px;">
            <?= esc_html($primary_cta['label']) ?> <span>&rarr;</span>
          </a>
        <?php endif; ?>
        <?php if (!empty($secondary_cta['url'])): ?>
          <a href="<?= esc_url($secondary_cta['url']) ?>" class="iiq-btn-ghost" style="font-size: 14px; font-weight: 500; padding: 14px 24px; background: transparent; color: <?= $dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>; text-decoration: none; border: <?= $dark ? '1px solid oklch(30% 0.005 286)' : '1px solid var(--border-default)' ?>; border-radius: 6px;">
            <?= esc_html($secondary_cta['label']) ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
