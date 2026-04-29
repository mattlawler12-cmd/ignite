<?php if (!defined('ABSPATH')) exit; ?>
<?php
$layers = [
    ['tag' => 'CHAT &middot; UI', 'name' => 'Armory Surface', 'sub' => 'natural language + dashboards', 'accent' => false],
    ['tag' => 'AGENTS', 'name' => 'Role-specific operators', 'sub' => 'cfo &middot; dispatch &middot; marketing &middot; success', 'accent' => false],
    ['tag' => 'TOOLS', 'name' => 'Decision tooling', 'sub' => 'analytics &middot; signals &middot; alerts', 'accent' => false],
    ['tag' => 'ONTOLOGY', 'name' => 'Structured intelligence', 'sub' => '12 entities &middot; resolved across systems', 'accent' => true],
    ['tag' => 'INTERFACE', 'name' => 'Read scope &middot; audited', 'sub' => 'queries customer marts under scoped role', 'accent' => false],
];
$last = count($layers) - 1;
?>
<div style="border-radius: 12px; padding: 12px; background: oklch(11% 0.004 286); border: 1px solid oklch(22% 0.005 286);">
  <?php foreach ($layers as $i => $l): ?>
    <div style="padding: 20px 22px; border-radius: 8px; margin-bottom: <?= $i === $last ? '0' : '6px' ?>; background: <?= $l['accent'] ? 'oklch(15% 0.005 286)' : 'oklch(13% 0.004 286)' ?>; border: <?= $l['accent'] ? '1px solid var(--ignite-500)' : '1px solid oklch(20% 0.005 286)' ?>; display: flex; align-items: center; justify-content: space-between; gap: 16px;">
      <div>
        <div style="font-family: var(--font-mono); font-size: 10px; letter-spacing: 0.18em; text-transform: uppercase; color: <?= $l['accent'] ? 'var(--ignite-400)' : 'oklch(55% 0.005 286)' ?>;"><?= $l['tag'] ?></div>
        <div style="margin-top: 6px; font-family: var(--font-display); font-size: 18px; font-weight: 600; letter-spacing: -0.02em; color: var(--ink-50);"><?= esc_html($l['name']) ?></div>
      </div>
      <div style="font-size: 12px; color: oklch(65% 0.005 286); text-align: right; max-width: 200px;"><?= $l['sub'] ?></div>
    </div>
  <?php endforeach; ?>
</div>
