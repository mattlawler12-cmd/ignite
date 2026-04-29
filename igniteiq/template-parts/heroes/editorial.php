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
// FIDELITY: Company.js hero (Company.js:24-40) renders inline 2-tone at
// clamp(44,5.2vw,88px), lineHeight 1.06, 600 weight — different from the
// existing 'compact' (huge stacked headline) and the auto 'is_long' shrink.
$is_inline_2tone = ($size_variant === 'inline-2tone');
$h1_font_size      = $is_inline_2tone ? 'clamp(44px, 5.2vw, 88px)' : ($is_long ? 'clamp(36px, 4.6vw, 72px)' : ($is_compact ? 'clamp(56px, 8.4vw, 144px)' : 'clamp(64px, 11vw, 184px)'));
$h1_line_height    = $is_inline_2tone ? '1.06' : ($is_long ? '1.04' : ($is_compact ? '0.94' : '0.92'));
$h1_font_weight    = $is_inline_2tone ? '600' : ($is_long ? '600' : '700');
$h1_letter_spacing = $is_inline_2tone ? '-0.04em' : ((!$is_long && $is_compact) ? '-0.05em' : '-0.04em');

$total_lines = count($headline_lines);
?>
<?php
// FIDELITY: inline-2tone (Company.js hero) uses padding 168/140 with NO
// min-height (Company.js:5-9 sets only padding). Other variants keep the
// existing 100vh treatment used by ArchHero/CompanyHero-cinematic.
$section_min_height = $is_inline_2tone ? 'auto' : 'calc(100vh - 64px)';
$section_align = $is_inline_2tone ? 'flex-start' : 'center';
$inner_padding = $is_inline_2tone ? '168px 32px 140px' : '96px 32px';
?>
<section style="position: relative; min-height: <?= $section_min_height ?>; background: <?= $dark ? 'var(--ink-1000)' : 'var(--bg-canvas)' ?>; color: <?= $dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>; overflow: hidden; border-bottom: <?= $dark ? '1px solid oklch(20% 0.005 286)' : '1px solid var(--border-subtle)' ?>; display: flex; align-items: <?= $section_align ?>;">
  <div style="max-width: 1440px; margin: 0 auto; padding: <?= $inner_padding ?>; width: 100%; position: relative;">
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
          ? ($dark ? 'oklch(60% 0.005 286)' : 'var(--fg-tertiary)')
          : ($dark ? 'var(--ink-50)' : 'var(--fg-primary)');
        // inline-2tone: lines flow inline with a separating space; all
        // other variants keep the block-stacked rendering.
        $span_display = $is_inline_2tone ? '' : 'display: block;';
        $span_separator = ($is_inline_2tone && $i > 0) ? ' ' : '';
      ?>
        <?= $span_separator ?><span style="<?= $span_display ?> color: <?= $color ?>; opacity: 1;"><?= esc_html($line) ?></span>
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
      <div style="margin-top: 80px; padding-top: 32px; border-top: <?= $dark ? '1px solid oklch(22% 0.005 286)' : '1px solid var(--border-default)' ?>; display: grid; grid-template-columns: repeat(<?= count($stats) ?>, 1fr); gap: 24px;">
        <?php foreach ($stats as $stat):
          $label = is_array($stat) ? ($stat['label'] ?? '') : '';
          $value = is_array($stat) ? ($stat['value'] ?? '') : '';
        ?>
          <div>
            <div style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.18em; text-transform: uppercase; color: <?= $dark ? 'oklch(50% 0.005 286)' : 'var(--fg-tertiary)' ?>;"><?= esc_html($label) ?></div>
            <div style="margin-top: 8px; font-family: var(--font-display); font-size: 20px; font-weight: 500; letter-spacing: -0.015em; color: <?= $dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>;"><?= esc_html($value) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
