<?php if (!defined('ABSPATH')) exit; ?>
<?php
// Isometric stack diagram — Data → Logic → Actions
// Cream background, three stacked diamond planes with side annotations.

$index    = get_sub_field('index') ?: '02';
$eyebrow  = get_sub_field('eyebrow') ?: 'The stack';
$headline_pre    = get_sub_field('headline_pre') ?: 'The most intelligent';
$headline_accent = get_sub_field('headline_accent') ?: 'infrastructure';
$headline_post   = get_sub_field('headline_post') ?: 'in home services';

$cx = 500;
$halfW = 300;
$halfH = 120;
$planeY = [140, 320, 500];

function iiq_rhombus($cx, $cy, $w, $h) {
    return ($cx) . ',' . ($cy - $h) . ' ' . ($cx + $w) . ',' . ($cy) . ' ' . ($cx) . ',' . ($cy + $h) . ' ' . ($cx - $w) . ',' . ($cy);
}

$cream = '#FFFFFF';
$ink = 'var(--ink-1000)';
$accent = 'var(--ignite-500)';

$chips = [
    ['DATA', 'INFORMATION'],
    ['LOGIC', 'INTELLIGENCE'],
    ['ACTIONS', 'OUTCOMES'],
];

$captions = [
    ['DATA', '[Information]', 'Your cloud warehouse — Snowflake, BigQuery, or Databricks. 25+ operational systems sync in: ServiceTitan, FieldEdge, accounting, marketing, telephony. Raw, staged, marted. Always under your IAM, never copied out.'],
    ['LOGIC', '[Intelligence]', 'The ontology — twelve resolved entities (job, technician, lead, invoice, customer, equipment) that compose every business question. The shared object model that lets agents and operators speak the same language as the data.'],
    ['ACTIONS', '[Outcomes]', 'Chat, signals, agents, decisions. The surface where operators ask, are told, and act. Every action is grounded in the ontology and writes back through the systems your team already uses.'],
];
?>
<section data-reveal style="padding: 110px 32px 120px; background: <?= esc_attr($cream) ?>; border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle); position: relative; overflow: hidden;">
  <div style="max-width: 1240px; margin: 0 auto; position: relative;">
    <?php // Section header — left-aligned ?>
    <div style="display: flex; align-items: center; gap: 16px; padding-bottom: 64px; font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--fg-tertiary);">
      <span><?= esc_html($index) ?></span>
      <span><?= esc_html($eyebrow) ?></span>
    </div>

    <div data-reveal>
      <h2 style="font-family: var(--font-display); font-size: clamp(40px, 5.2vw, 76px); font-weight: 600; letter-spacing: -0.04em; line-height: 1.0; margin: 0 auto; color: <?= esc_attr($ink) ?>; text-align: center; max-width: 900px;">
        <?= esc_html($headline_pre) ?> <span style="color: <?= esc_attr($accent) ?>;"><?= esc_html($headline_accent) ?></span> <?= esc_html($headline_post) ?>
      </h2>
    </div>

    <?php // Three pill chips ?>
    <div style="margin-top: 36px; display: flex; align-items: center; justify-content: center; gap: 12px; flex-wrap: wrap;">
      <?php foreach ($chips as $i => $chip): [$k, $v] = $chip; ?>
        <div style="padding: 12px 20px; border: 1.5px solid <?= $i === 1 ? esc_attr($accent) : esc_attr($ink) ?>; color: <?= $i === 1 ? esc_attr($accent) : esc_attr($ink) ?>; background: transparent; font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; font-weight: 600; display: flex; align-items: center; gap: 8px; border-radius: 2px;">
          <span><?= esc_html($k) ?></span>
          <span style="opacity: 0.55;">[<?= esc_html($v) ?>]</span>
        </div>
        <?php if ($i < 2): ?>
          <div style="width: 30px; height: 30px; border-radius: 50%; border: 1.4px solid <?= esc_attr($ink) ?>; display: flex; align-items: center; justify-content: center; color: <?= esc_attr($ink) ?>; font-family: var(--font-mono); font-weight: 600; font-size: 14px;">+</div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>

    <?php // Stack diagram ?>
    <div style="margin-top: 56px; position: relative; width: 100%; max-width: 780px; margin: 56px auto 0;">
      <svg viewBox="0 0 1000 720" width="100%" style="display: block; overflow: visible;">
        <defs>
          <linearGradient id="igniteGrad" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" stop-color="oklch(58% 0.232 25)" stop-opacity="0.95" />
            <stop offset="50%" stop-color="oklch(70% 0.18 30)" stop-opacity="0.55" />
            <stop offset="100%" stop-color="oklch(80% 0.12 35)" stop-opacity="0.05" />
          </linearGradient>
        </defs>

        <?php // Plane 3 — BOTTOM — Your warehouse ?>
        <polygon points="<?= esc_attr(iiq_rhombus($cx, $planeY[2], $halfW, $halfH)) ?>" fill="url(#igniteGrad)" stroke="oklch(58% 0.232 25)" stroke-width="1.2" />

        <?php // Plane 2 — MIDDLE — Resolved Ontology (grid plane) ?>
        <g>
          <polygon points="<?= esc_attr(iiq_rhombus($cx, $planeY[1], $halfW, $halfH)) ?>" fill="<?= esc_attr($cream) ?>" stroke="<?= esc_attr($ink) ?>" stroke-width="1.2" />
          <?php
          $T = ['x' => $cx, 'y' => $planeY[1] - $halfH];
          $R = ['x' => $cx + $halfW, 'y' => $planeY[1]];
          $B = ['x' => $cx, 'y' => $planeY[1] + $halfH];
          $L = ['x' => $cx - $halfW, 'y' => $planeY[1]];
          $lerp = function($a, $b, $t) { return ['x' => $a['x'] + ($b['x'] - $a['x']) * $t, 'y' => $a['y'] + ($b['y'] - $a['y']) * $t]; };
          foreach ([0.2, 0.4, 0.6, 0.8] as $t) {
            $p1 = $lerp($L, $T, $t);
            $p2 = $lerp($B, $R, $t);
            echo '<line x1="' . $p1['x'] . '" y1="' . $p1['y'] . '" x2="' . $p2['x'] . '" y2="' . $p2['y'] . '" stroke="' . esc_attr($ink) . '" stroke-width="0.9" />';
          }
          foreach ([0.2, 0.4, 0.6, 0.8] as $t) {
            $p1 = $lerp($T, $R, $t);
            $p2 = $lerp($L, $B, $t);
            echo '<line x1="' . $p1['x'] . '" y1="' . $p1['y'] . '" x2="' . $p2['x'] . '" y2="' . $p2['y'] . '" stroke="' . esc_attr($ink) . '" stroke-width="0.9" />';
          }
          ?>
        </g>

        <?php // Plane 1 — TOP — Decisions & Agents ?>
        <g>
          <polygon points="<?= esc_attr(iiq_rhombus($cx, $planeY[0], $halfW, $halfH)) ?>" fill="<?= esc_attr($ink) ?>" stroke="<?= esc_attr($ink) ?>" stroke-width="1.4" />
          <?php foreach ([0.85, 0.68, 0.50, 0.32, 0.16] as $s): ?>
            <polygon points="<?= esc_attr(iiq_rhombus($cx, $planeY[0], $halfW * $s, $halfH * $s)) ?>" fill="none" stroke="oklch(38% 0.01 286)" stroke-width="0.9" opacity="0.85" />
          <?php endforeach; ?>
        </g>

        <?php // Connector lines ?>
        <line x1="<?= $cx - $halfW ?>" y1="<?= $planeY[0] ?>" x2="105" y2="<?= $planeY[0] ?>" stroke="<?= esc_attr($ink) ?>" stroke-width="1.2" />
        <line x1="<?= $cx + $halfW ?>" y1="<?= $planeY[1] ?>" x2="895" y2="<?= $planeY[1] ?>" stroke="<?= esc_attr($ink) ?>" stroke-width="1.2" />
        <line x1="<?= $cx - $halfW ?>" y1="<?= $planeY[2] ?>" x2="105" y2="<?= $planeY[2] ?>" stroke="<?= esc_attr($ink) ?>" stroke-width="1.2" />

        <g font-family="var(--font-display)" font-size="20" font-weight="600" letter-spacing="-0.01em">
          <text x="910" y="<?= $planeY[1] - 6 ?>" fill="<?= esc_attr($ink) ?>">Your</text>
          <text x="910" y="<?= $planeY[1] + 18 ?>" fill="<?= esc_attr($ink) ?>">logic</text>

          <text x="90" y="<?= $planeY[0] - 6 ?>" fill="<?= esc_attr($ink) ?>" text-anchor="end">Your decisions</text>
          <text x="90" y="<?= $planeY[0] + 18 ?>" fill="<?= esc_attr($ink) ?>" text-anchor="end">& actions</text>

          <text x="90" y="<?= $planeY[2] - 6 ?>" fill="<?= esc_attr($accent) ?>" text-anchor="end">Your</text>
          <text x="90" y="<?= $planeY[2] + 18 ?>" fill="<?= esc_attr($accent) ?>" text-anchor="end">data</text>
        </g>
      </svg>
    </div>

    <?php // Three caption columns explaining each layer ?>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 48px; padding-top: 32px; border-top: 1px solid <?= esc_attr($ink) ?>; max-width: 1100px; margin: 64px auto 0;">
      <?php foreach ($captions as $i => $cap): [$k, $v, $body] = $cap; ?>
        <div data-reveal data-reveal-delay="<?= esc_attr($i * 100) ?>">
          <div style="font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: <?= $i === 1 ? esc_attr($accent) : esc_attr($ink) ?>; font-weight: 600;">
            <?= esc_html($k) ?> <span style="opacity: 0.55;"><?= esc_html($v) ?></span>
          </div>
          <p style="margin-top: 18px; font-size: 15px; line-height: 1.55; color: <?= esc_attr($ink) ?>; margin: 18px 0 0;"><?= esc_html($body) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
