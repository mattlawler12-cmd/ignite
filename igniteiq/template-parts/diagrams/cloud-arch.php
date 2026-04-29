<?php if (!defined('ABSPATH')) exit; ?>
<?php
$sources = ['ServiceTitan', 'QuickBooks', 'CallRail', 'Google Ads', 'Meta', 'Salesforce', 'Stripe', 'Gusto', 'Podium', 'Sheets'];
?>
<div style="padding: 32px 30px; border-radius: 12px; background: var(--bg-surface); border: 1px solid var(--border-default);">
  <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; margin-bottom: 24px;">
    <?php foreach ($sources as $s): ?>
      <div style="padding: 8px 12px; border-radius: 4px; background: #fff; border: 1px solid var(--border-subtle); font-size: 12px; font-family: var(--font-mono); letter-spacing: 0.04em; color: var(--fg-secondary);"><?= esc_html($s) ?></div>
    <?php endforeach; ?>
  </div>
  <div style="height: 18px; display: flex; align-items: center; justify-content: center;"><span style="color: var(--fg-tertiary); font-size: 18px;">&darr;</span></div>
  <div style="margin-top: 24px; padding: 16px 18px; border-radius: 6px; border: 1px solid var(--border-default); background: #fff;">
    <div style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-tertiary);">Pipelines</div>
    <div style="font-family: var(--font-display); font-size: 18px; font-weight: 600; letter-spacing: -0.02em; margin-top: 4px;">Fivetran + dbt</div>
  </div>
  <div style="height: 18px; display: flex; align-items: center; justify-content: center;"><span style="color: var(--fg-tertiary); font-size: 18px;">&darr;</span></div>
  <div style="margin-top: 24px; padding: 24px 26px; border-radius: 8px; background: var(--ink-1000); color: var(--ink-50);">
    <div style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.16em; text-transform: uppercase; color: var(--ignite-400);">Customer warehouse</div>
    <div style="font-family: var(--font-display); font-size: 24px; font-weight: 600; letter-spacing: -0.025em; margin-top: 6px;">Snowflake / BigQuery</div>
    <div style="margin-top: 10px; font-size: 12px; color: oklch(70% 0.005 286);">customer-owned &middot; IAM-scoped &middot; audit logged</div>
  </div>
</div>
