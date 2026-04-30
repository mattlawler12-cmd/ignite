<?php
if (!defined('ABSPATH')) exit;
$eyebrow        = get_sub_field('eyebrow') ?: '';
$headline_lines = get_sub_field('headline_lines') ?: [];
$body           = get_sub_field('body') ?: '';
$primary_cta    = get_sub_field('primary_cta') ?: ['label' => '', 'url' => ''];
$secondary_cta  = get_sub_field('secondary_cta') ?: ['label' => '', 'url' => ''];
$dark           = get_sub_field('dark') ? true : false;
$size_variant   = get_sub_field('size_variant') ?: '';
$stats          = get_sub_field('stats') ?: [];

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
$is_compact = ($size_variant === 'compact');
// FIDELITY: 'inline-2tone' is Company.js hero size (clamp 44,5.2vw,88).
// 'compact' is ArchHero/big-headline size (clamp 56,8.4vw,144).
// Default is the original cinematic huge clamp.
$is_inline_2tone = ($size_variant === 'inline-2tone');
$h1_font_size      = $is_inline_2tone ? 'clamp(44px, 5.2vw, 88px)' : ($is_long ? 'clamp(36px, 4.6vw, 72px)' : ($is_compact ? 'clamp(56px, 8.4vw, 144px)' : 'clamp(64px, 11vw, 184px)'));
$h1_line_height    = $is_inline_2tone ? '1.06' : ($is_long ? '1.04' : ($is_compact ? '0.94' : '0.92'));
// FIDELITY: Architecture.js ArchHero uses fontWeight 600 (line 100), not
// the 700 the previous default assumed. Compact + non-long defaults to 600.
$h1_font_weight    = $is_inline_2tone ? '600' : ($is_long ? '600' : ($is_compact ? '600' : '700'));
$h1_letter_spacing = $is_inline_2tone ? '-0.04em' : ((!$is_long && $is_compact) ? '-0.05em' : '-0.04em');

// Decouple inline-flow from size: an explicit `headline_inline` flag opts
// any size_variant into inline rendering with no separating space (the
// caller controls whitespace via leading/trailing spaces inside each
// line). Used by ArchHero (compact size + inline 4-segment two-tone:
// "Built on" + tertiary " your cloud. " + "Run on" + tertiary " your data.")
// — Architecture.js:96-115. inline-2tone implies inline by default.
$headline_inline = (bool) get_sub_field('headline_inline');
$is_inline = $headline_inline || $is_inline_2tone;

$total_lines = count($headline_lines);
?>
<?php
// FIDELITY:
// - inline-2tone (Company.js): padding 168/140, no min-height
// - compact (ArchHero, Architecture.js:71): padding 180/140, no min-height
// - default (legacy huge cinematic hero): keep 100vh + 96px padding
$section_min_height = ($is_inline_2tone || $is_compact) ? 'auto' : 'calc(100vh - 64px)';
$section_align = ($is_inline_2tone || $is_compact) ? 'flex-start' : 'center';
$inner_padding = $is_inline_2tone
    ? '168px 32px 140px'
    : ($is_compact ? '180px 32px 140px' : '96px 32px');
$inner_max_width = $is_compact ? '1320px' : '1440px';
?>
<section style="position: relative; min-height: <?= $section_min_height ?>; background: <?= $dark ? 'var(--ink-1000)' : 'var(--bg-canvas)' ?>; color: <?= $dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>; overflow: hidden; border-bottom: <?= $dark ? '1px solid oklch(20% 0.005 286)' : '1px solid var(--border-subtle)' ?>; display: flex; align-items: <?= $section_align ?>;">
  <?php /* FIDELITY EXCEPTION: ArchHero red radial glow (Architecture.js:78-86) removed per stakeholder direction — solid bg requested for visual calm. */ ?>
  <div style="max-width: <?= $inner_max_width ?>; margin: 0 auto; padding: <?= $inner_padding ?>; width: 100%; position: relative;">
    <?php if ($eyebrow): ?>
      <span class="iiq-eyebrow" style="font-family: 'Aeonik Fono', monospace; font-size: 11px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--ignite-500); display: inline-flex; align-items: center; gap: 8px;">
        <span style="width:6px;height:6px;border-radius:50%;background:var(--ignite-500);animation: iiqPulse 2s ease-in-out infinite;"></span>
        <?= esc_html($eyebrow) ?>
      </span>
    <?php endif; ?>
    <h1 style="font-family: var(--font-display); font-size: <?= $h1_font_size ?>; line-height: <?= $h1_line_height ?>; font-weight: <?= $h1_font_weight ?>; letter-spacing: <?= $h1_letter_spacing ?>; margin: 32px 0 0; color: <?= $dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>; max-width: 1400px;">
      <?php
      // Detect explicit per-line `muted` flags. If any line declares one,
      // use them; otherwise fall back to legacy auto (last line primary,
      // earlier lines muted).
      $has_explicit_muted = false;
      foreach ($headline_lines as $row) {
        if (is_array($row) && array_key_exists('muted', $row)) { $has_explicit_muted = true; break; }
      }
      foreach ($headline_lines as $i => $row):
        $line  = is_array($row) ? ($row['line'] ?? '') : $row;
        $is_last = ($i === $total_lines - 1);
        $is_muted = $has_explicit_muted
          ? !empty($row['muted'])
          : (!$is_last && $total_lines > 1);
        $color = $is_muted
          ? ($dark ? 'var(--ink-50)' : 'var(--fg-tertiary)')
          : ($dark ? 'var(--ink-50)' : 'var(--fg-primary)');
        // Inline rendering: $is_inline_2tone emits an automatic separating
        // space between lines (Company convention — line text has no leading
        // spaces). Generic $headline_inline (ArchHero) emits NO separator —
        // caller controls whitespace via leading/trailing spaces inside
        // each line string (Architecture.js:96-115 uses this pattern).
        $span_display = $is_inline ? '' : 'display: block;';
        $span_separator = ($is_inline_2tone && $i > 0) ? ' ' : '';
      ?>
        <?= $span_separator ?><span style="<?= $span_display ?> color: <?= $color ?>; opacity: 1;"><?= esc_html($line) ?></span>
      <?php endforeach; ?>
    </h1>
    <?php
    // FIDELITY: ArchHero body sits 40px below H1 with maxWidth 740 + fontSize 19
    // + lineHeight 1.55 + color oklch(78%) (Architecture.js:115-122). Other
    // editorial heroes use 64px top + 640 max-width + oklch(75%) (legacy).
    $body_grid_margin = $is_compact ? '40px' : '64px';
    $body_max_width   = $is_compact ? '740px' : '640px';
    $body_color_dark  = $is_compact ? 'var(--ink-50)' : 'oklch(75% 0.005 286)';
    ?>
    <div style="margin-top: <?= $body_grid_margin ?>; display: grid; grid-template-columns: 1fr auto; gap: 64px; align-items: flex-end;">
      <?php if ($body): ?>
        <div class="iiq-hero-body" style="max-width: <?= $body_max_width ?>; font-size: 19px; line-height: 1.55; color: <?= $dark ? $body_color_dark : 'var(--fg-secondary)' ?>; letter-spacing: -0.005em; margin: 0;">
          <?= wp_kses_post($body) ?>
        </div>
      <?php else: ?>
        <div></div>
      <?php endif; ?>
      <?php $has_primary = !empty($primary_cta['label']); ?>
      <?php $has_secondary = !empty($secondary_cta['label']); ?>
      <?php if ($has_primary || $has_secondary): ?>
        <div style="display: flex; gap: 12px;">
          <?php if ($has_primary): ?>
            <a href="<?= esc_url($primary_cta['url'] ?? '#') ?>" class="iiq-btn" style="font-size: 14px; font-weight: 500; padding: 14px 24px; background: var(--ignite-500); color: #fff; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border-radius: 6px;">
              <?= esc_html($primary_cta['label']) ?> <span>&rarr;</span>
            </a>
          <?php endif; ?>
          <?php if ($has_secondary): ?>
            <a href="<?= esc_url($secondary_cta['url'] ?? '#') ?>" class="iiq-btn-ghost" style="font-size: 14px; font-weight: 500; padding: 14px 24px; background: transparent; color: <?= $dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>; text-decoration: none; border: <?= $dark ? '1px solid oklch(30% 0.005 286)' : '1px solid var(--border-default)' ?>; border-radius: 6px;">
              <?= esc_html($secondary_cta['label']) ?>
            </a>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <div></div>
      <?php endif; ?>
    </div>

    <?php if (!empty($stats) && is_array($stats)): ?>
      <div class="iiq-hero-stats" style="margin-top: 80px; padding-top: 32px; border-top: <?= $dark ? '1px solid oklch(22% 0.005 286)' : '1px solid var(--border-default)' ?>; display: grid; grid-template-columns: repeat(<?= count($stats) ?>, 1fr); gap: 24px;">
        <?php foreach ($stats as $stat):
          $label = is_array($stat) ? ($stat['label'] ?? '') : '';
          $value = is_array($stat) ? ($stat['value'] ?? '') : '';
        ?>
          <div>
            <div style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.18em; text-transform: uppercase; color: <?= $dark ? 'var(--ignite-500)' : 'var(--fg-tertiary)' ?>;"><?= esc_html($label) ?></div>
            <div style="margin-top: 8px; font-family: var(--font-display); font-size: 20px; font-weight: 500; letter-spacing: -0.015em; color: <?= $dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>;"><?= esc_html($value) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
