<?php
if (!defined('ABSPATH')) exit;
$eyebrow        = get_sub_field('eyebrow') ?: '';
$headline_lines = get_sub_field('headline_lines') ?: [];
$body           = get_sub_field('body') ?: '';
$primary_cta    = get_sub_field('primary_cta') ?: ['label' => '', 'url' => ''];
$secondary_cta  = get_sub_field('secondary_cta') ?: ['label' => '', 'url' => ''];
$stats          = get_sub_field('stats') ?: [];

if (empty($headline_lines)) {
    $headline_lines = [
        ['line' => 'The intelligence layer'],
        ['line' => 'the trades have been waiting for.'],
    ];
}
if (empty($stats)) {
    $stats = [
        ['label' => 'Time to deployed',   'value' => '< 7 days'],
        ['label' => 'Systems unified',    'value' => '25+'],
        ['label' => 'Customer-owned',     'value' => '100%'],
        ['label' => 'Framework version',  'value' => 'v4.2'],
    ];
}
if (empty($body)) {
    $body = "The team that helped build ServiceTitan, alongside operators who've run the trucks and the dispatch board, building the intelligence layer the trades have been waiting for. Deployed in your cloud. Live in days.";
}

$headline_concat = '';
foreach ($headline_lines as $row) {
    $headline_concat .= (is_array($row) ? ($row['line'] ?? '') : $row) . "\n";
}
$is_long = strlen($headline_concat) > 80;
$h1_font_size   = $is_long ? 'clamp(36px, 4.6vw, 72px)' : 'clamp(60px, 11vw, 188px)';
$h1_line_height = $is_long ? '1.04' : '0.92';
$h1_font_weight = $is_long ? '600' : '700';
$total_lines = count($headline_lines);

$corners = [
    'tl' => 'top: 88px; left: 32px; border-top: 1px solid oklch(50% 0.005 286); border-left: 1px solid oklch(50% 0.005 286);',
    'tr' => 'top: 88px; right: 32px; border-top: 1px solid oklch(50% 0.005 286); border-right: 1px solid oklch(50% 0.005 286);',
    'bl' => 'bottom: 32px; left: 32px; border-bottom: 1px solid oklch(50% 0.005 286); border-left: 1px solid oklch(50% 0.005 286);',
    'br' => 'bottom: 32px; right: 32px; border-bottom: 1px solid oklch(50% 0.005 286); border-right: 1px solid oklch(50% 0.005 286);',
];
?>
<section style="position: relative; min-height: 100vh; background: var(--ink-1000); color: var(--ink-50); overflow: hidden; display: flex; flex-direction: column;">
  <div style="position: absolute; inset: 0;">
    <?php if (locate_template('template-parts/diagrams/lattice.php')) get_template_part('template-parts/diagrams/lattice'); ?>
  </div>
  <div style="position: absolute; inset: 0; background: radial-gradient(ellipse at 70% 30%, oklch(57.5% 0.232 25 / 0.18), transparent 50%), linear-gradient(to bottom, oklch(7.5% 0.003 286 / 0.2), oklch(7.5% 0.003 286 / 0.85) 90%); pointer-events: none;"></div>
  <?php foreach ($corners as $key => $css): ?>
    <div style="position: absolute; width: 18px; height: 18px; <?= $css ?>"></div>
  <?php endforeach; ?>
  <div style="max-width: 1440px; margin: 0 auto; padding: 120px 32px 0; position: relative; flex: 1; display: flex; flex-direction: column; justify-content: center; width: 100%;">
    <?php if ($eyebrow): ?>
      <span class="iiq-eyebrow" style="font-family: 'Aeonik Fono', monospace; font-size: 11px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--ignite-500); display: inline-flex; align-items: center; gap: 8px;">
        <span style="width:6px;height:6px;border-radius:50%;background:var(--ignite-500);animation: iiqPulse 2s ease-in-out infinite;"></span>
        <?= esc_html($eyebrow) ?>
      </span>
    <?php endif; ?>
    <h1 style="font-family: var(--font-display); font-size: <?= $h1_font_size ?>; line-height: <?= $h1_line_height ?>; font-weight: <?= $h1_font_weight ?>; letter-spacing: -0.04em; margin: 24px 0 0; color: var(--ink-50); max-width: 1300px;">
      <?php foreach ($headline_lines as $i => $row):
        $line = is_array($row) ? ($row['line'] ?? '') : $row;
        $is_last = ($i === $total_lines - 1);
        $is_muted = (!$is_last && $total_lines > 1);
        $color = $is_muted ? 'oklch(60% 0.005 286)' : 'var(--ink-50)';
      ?>
        <span style="display: block; color: <?= $color ?>;"><?= esc_html($line) ?></span>
      <?php endforeach; ?>
    </h1>
    <div style="max-width: 740px; font-size: 19px; line-height: 1.55; color: oklch(78% 0.005 286); letter-spacing: -0.005em; margin: 40px 0 0;">
      <?= wp_kses_post($body) ?>
    </div>
    <div style="margin-top: 48px; display: flex; gap: 12px;">
      <?php if (!empty($primary_cta['url'])): ?>
        <a href="<?= esc_url($primary_cta['url']) ?>" class="iiq-btn" style="font-size: 14px; font-weight: 500; padding: 14px 24px; background: var(--ignite-500); color: #fff; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border-radius: 6px; box-shadow: 0 0 0 1px oklch(57.5% 0.232 25 / 0.4), 0 8px 32px -4px oklch(57.5% 0.232 25 / 0.4);">
          <?= esc_html($primary_cta['label']) ?> <span>&rarr;</span>
        </a>
      <?php endif; ?>
      <?php if (!empty($secondary_cta['url'])): ?>
        <a href="<?= esc_url($secondary_cta['url']) ?>" class="iiq-btn-ghost" style="font-size: 14px; font-weight: 500; padding: 14px 24px; background: oklch(15% 0.005 286 / 0.6); color: var(--ink-50); text-decoration: none; border: 1px solid oklch(28% 0.005 286); border-radius: 6px; backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
          <?= esc_html($secondary_cta['label']) ?>
        </a>
      <?php endif; ?>
    </div>
    <?php if (!empty($stats)): ?>
      <div style="margin-top: 96px; padding-top: 28px; border-top: 1px solid oklch(22% 0.005 286); display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px;">
        <?php foreach ($stats as $stat):
          $label = is_array($stat) ? ($stat['label'] ?? '') : '';
          $value = is_array($stat) ? ($stat['value'] ?? '') : '';
        ?>
          <div>
            <div style="font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: oklch(50% 0.005 286);"><?= esc_html($label) ?></div>
            <div style="margin-top: 8px; font-family: var(--font-display); font-size: 32px; font-weight: 600; letter-spacing: -0.025em; color: var(--ink-50);"><?= esc_html($value) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
