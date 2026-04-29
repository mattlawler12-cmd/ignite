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
    <?php
      // Detect whether any line carries an explicit 'muted' flag (true OR false).
      // If so, that flag drives per-line color exclusively. If no line declares
      // 'muted', fall back to legacy auto-behavior (lead lines muted, last line
      // primary) to preserve existing seeds (e.g. signin) that haven't migrated.
      $has_explicit_muted = false;
      foreach ($headline_lines as $row) {
          if (is_array($row) && array_key_exists('muted', $row)) {
              $has_explicit_muted = true;
              break;
          }
      }
    ?>
    <?php
      // FIDELITY: when an explicit `muted` flag is present (e.g. ContactHero,
      // Contact.js:29-44 — "Let's talk." primary + tertiary inline span on
      // the second sentence), render lines INLINE with separating spaces
      // and use the larger Contact-spec clamp(56,7.6vw,132px). When no
      // explicit muted is set (signin, etc.), keep block-stacked layout
      // with the existing 44/5.2vw/88px clamp.
      $h1_font_size      = $has_explicit_muted ? 'clamp(56px, 7.6vw, 132px)' : 'clamp(44px, 5.2vw, 88px)';
      $h1_line_height    = $has_explicit_muted ? '0.94' : '1.06';
      $h1_letter_spacing = $has_explicit_muted ? '-0.05em' : '-0.04em';
      $h1_max_width      = $has_explicit_muted ? '1280px' : '1240px';
    ?>
    <h1 style="font-family: var(--font-display); font-size: <?= $h1_font_size ?>; line-height: <?= $h1_line_height ?>; font-weight: 600; letter-spacing: <?= $h1_letter_spacing ?>; margin: 40px 0 0; color: var(--fg-primary); max-width: <?= $h1_max_width ?>; text-wrap: balance;">
      <?php foreach ($headline_lines as $i => $row):
        $line = is_array($row) ? ($row['line'] ?? '') : $row;
        if ($has_explicit_muted) {
            $is_muted = (is_array($row) && !empty($row['muted']));
        } else {
            $is_last = ($i === $total_lines - 1);
            $is_muted = (!$is_last && $total_lines > 1);
        }
        $color = $is_muted ? 'var(--fg-tertiary)' : 'var(--fg-primary)';
        $span_display = $has_explicit_muted ? '' : 'display: block;';
        $span_separator = ($has_explicit_muted && $i > 0) ? ' ' : '';
      ?>
        <?= $span_separator ?><span style="<?= $span_display ?> color: <?= $color ?>;"><?= esc_html($line) ?></span>
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
