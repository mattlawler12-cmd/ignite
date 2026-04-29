<?php if (!defined('ABSPATH')) exit; ?>
<?php
$customer_rows = [
    ['snowflake / bigquery', 'Warehouse'],
    ['raw + modeled', 'Tables'],
    ['dbt + fivetran', 'Pipelines'],
    ['iam / kms', 'Identity & access'],
];
$iiq_rows = [
    ['v4.2', 'Ontology framework'],
    ['scoped per tenant', 'AI agents'],
    ['live', 'Decision tools'],
    ['compounding', 'Edge cases'],
];
?>
<div style="border-radius: 12px; overflow: hidden; border: 1px solid var(--border-default); background: var(--bg-surface); box-shadow: 0 30px 60px -30px oklch(7.5% 0.003 286 / 0.18);">
  <div style="display: grid; grid-template-columns: 1fr 1fr;">
    <?php // Customer cloud ?>
    <div style="padding: 28px 28px 32px; border-right: 1px solid var(--border-subtle); background: var(--bg-sunken);">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <span style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--fg-tertiary);">Customer cloud</span>
        <span style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-secondary); padding: 3px 8px; border-radius: 3px; background: #fff; border: 1px solid var(--border-default);">YOUR ACCOUNT</span>
      </div>
      <h4 style="font-family: var(--font-display); font-size: 22px; font-weight: 600; letter-spacing: -0.025em; margin: 12px 0 18px; color: var(--fg-primary);">Infrastructure</h4>
      <?php foreach ($customer_rows as $row): [$k, $v] = $row; ?>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-top: 1px solid var(--border-subtle);">
          <span style="font-size: 13px; color: var(--fg-secondary);"><?= esc_html($v) ?></span>
          <span style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-tertiary);"><?= esc_html($k) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
    <?php // IgniteIQ IP ?>
    <div style="padding: 28px 28px 32px; position: relative; background: var(--ink-1000); color: var(--ink-50);">
      <?php // signal red leading edge ?>
      <div style="position: absolute; left: 0; top: 24px; bottom: 24px; width: 2px; background: var(--ignite-500);"></div>
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <span style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--ignite-400);">IgniteIQ &middot; runs in your cloud</span>
        <span style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--ink-50); padding: 3px 8px; border-radius: 3px; background: oklch(20% 0.005 286); border: 1px solid oklch(28% 0.005 286);">SCOPED TO YOU</span>
      </div>
      <h4 style="font-family: var(--font-display); font-size: 22px; font-weight: 600; letter-spacing: -0.025em; margin: 12px 0 18px; color: var(--ink-50);">Intelligence</h4>
      <?php foreach ($iiq_rows as $row): [$k, $v] = $row; ?>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-top: 1px solid oklch(22% 0.005 286);">
          <span style="font-size: 13px; color: oklch(80% 0.005 286);"><?= esc_html($v) ?></span>
          <span style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.14em; text-transform: uppercase; color: var(--ignite-400);"><?= esc_html($k) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
