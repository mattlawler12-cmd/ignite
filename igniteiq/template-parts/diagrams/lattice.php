<?php if (!defined('ABSPATH')) exit; ?>
<?php
// Cinematic dark hero background — animated lattice canvas with vignette + corner crosshairs.
// Animation logic lives in /assets/js/lattice.js (auto-targets [data-iiq-lattice]).
$crosshairs = [
    ['tl', 'top: 88px; left: 32px;'],
    ['tr', 'top: 88px; right: 32px;'],
    ['bl', 'bottom: 32px; left: 32px;'],
    ['br', 'bottom: 32px; right: 32px;'],
];
?>
<div style="position: absolute; inset: 0;">
  <canvas data-iiq-lattice style="position: absolute; inset: 0; width: 100%; height: 100%; pointer-events: none; opacity: 0.85;"></canvas>
</div>
<?php // vignette + bottom fade ?>
<div style="position: absolute; inset: 0; background: radial-gradient(ellipse at 70% 30%, oklch(57.5% 0.232 25 / 0.18), transparent 50%), linear-gradient(to bottom, oklch(7.5% 0.003 286 / 0.2), oklch(7.5% 0.003 286 / 0.85) 90%); pointer-events: none;"></div>
<?php // corner crosshairs — tactical detail ?>
<?php foreach ($crosshairs as $ch): [$pos, $coords] = $ch;
  $bt = strpos($pos, 't') !== false ? '1px solid oklch(50% 0.005 286)' : 'none';
  $bb = strpos($pos, 'b') !== false ? '1px solid oklch(50% 0.005 286)' : 'none';
  $bl = strpos($pos, 'l') !== false ? '1px solid oklch(50% 0.005 286)' : 'none';
  $br = strpos($pos, 'r') !== false ? '1px solid oklch(50% 0.005 286)' : 'none';
?>
  <div style="position: absolute; width: 18px; height: 18px; <?= $coords ?> border-top: <?= $bt ?>; border-bottom: <?= $bb ?>; border-left: <?= $bl ?>; border-right: <?= $br ?>;"></div>
<?php endforeach; ?>
