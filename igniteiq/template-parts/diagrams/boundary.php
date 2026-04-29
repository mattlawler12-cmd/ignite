<?php if (!defined('ABSPATH')) exit; ?>
<?php
// Boundary diagram — two-column "what stays in the customer cloud" vs
// "what compounds in the IgniteIQ framework". Mirrors ArchCompoundingDiagram
// from the export (Architecture.js). Visible copy strings match the export
// byte-for-byte; SVG/visual structure preserved.

$customer_rows = [
    'Tables · raw + modeled',
    'Identity & access policies',
    'Customer records · job records · invoices',
    'Audit logs · query history',
];
$iiq_rows = [
    'Edge cases · resolution rules',
    'Integration shape · vendor quirks',
    'Decision heuristics · agent prompts',
    'Benchmark distributions · anonymized',
];
?>
<div style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-default); background: var(--bg-surface); box-shadow: 0 30px 60px -30px oklch(7.5% 0.003 286 / 0.18);">
  <div style="display: grid; grid-template-columns: 1fr 1fr;">
    <?php // Left column — Stays in customer cloud / Operational data ?>
    <div style="padding: 36px 32px; border-right: 1px solid var(--border-subtle); background: #fff;">
      <span style="font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--ignite-500); display: inline-flex; align-items: center; gap: 8px;">
        <span style="width:6px;height:6px;border-radius:50%;background:var(--ignite-500);"></span>
        Stays in customer cloud
      </span>
      <h3 style="font-family: var(--font-display); font-size: 26px; font-weight: 600; letter-spacing: -0.025em; margin: 16px 0 24px; color: var(--fg-primary);">Operational data</h3>
      <?php foreach ($customer_rows as $row): ?>
        <div style="padding: 10px 0; border-top: 1px solid var(--border-subtle); font-size: 14px; color: var(--fg-secondary);">
          <?= esc_html($row) ?>
        </div>
      <?php endforeach; ?>
    </div>
    <?php // Right column — Compounds in framework / Patterns & intelligence ?>
    <div style="padding: 36px 32px; position: relative; background: var(--ink-1000); color: var(--ink-50); overflow: hidden;">
      <div style="position: absolute; inset: 0; background: radial-gradient(circle at 70% 30%, oklch(57.5% 0.232 25 / 0.18), transparent 60%); pointer-events: none;"></div>
      <div style="position: relative;">
        <span style="font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--ignite-400); display: inline-flex; align-items: center; gap: 8px;">
          <span style="width:6px;height:6px;border-radius:50%;background:var(--ignite-400);"></span>
          Compounds in framework
        </span>
        <h3 style="font-family: var(--font-display); font-size: 26px; font-weight: 600; letter-spacing: -0.025em; margin: 16px 0 24px; color: var(--ink-50);">Patterns &amp; intelligence</h3>
        <?php foreach ($iiq_rows as $row): ?>
          <div style="padding: 10px 0; border-top: 1px solid oklch(22% 0.005 286); font-size: 14px; color: oklch(75% 0.005 286);">
            <?= esc_html($row) ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
