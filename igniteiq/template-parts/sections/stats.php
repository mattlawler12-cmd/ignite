<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$headline = get_sub_field('headline') ?: '';
$stats    = get_sub_field('stats') ?: [];
$style    = get_sub_field('style') ?: 'cards';
$variant  = iiq_section_variant();
$is_dark  = ($variant === 'dark');
$count    = is_array($stats) ? count($stats) : 0;
$cols     = $count >= 4 ? 4 : ($count === 3 ? 3 : ($count === 2 ? 2 : 1));
$is_bare  = ($style === 'bare');
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:1320px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <?php if ($headline): ?>
            <h2 class="iiq-display-md" style="margin:0 auto 56px;max-width:880px;text-align:center;font-family:var(--font-display);font-weight:600;letter-spacing:-0.025em;line-height:1.1;<?= $is_dark ? 'color:var(--ink-50);' : '' ?>">
                <?= wp_kses_post($headline) ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($stats) && is_array($stats)): ?>
            <div style="display:grid;grid-template-columns:repeat(<?= (int) $cols ?>,1fr);gap:<?= $is_bare ? '24px' : '24px' ?>;">
                <?php foreach ($stats as $stat):
                    $value    = isset($stat['value']) ? $stat['value'] : '';
                    $label    = isset($stat['label']) ? $stat['label'] : '';
                    $footnote = isset($stat['footnote']) ? $stat['footnote'] : '';
                ?>
                <?php if ($is_bare): ?>
                    <div style="display:flex;flex-direction:column;gap:14px;padding:8px 0;">
                        <?php if ($value !== ''): ?>
                            <span style="font-family:var(--font-display);font-size:clamp(40px,4.6vw,64px);line-height:1;font-weight:600;letter-spacing:-0.03em;color:<?= $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>;">
                                <?= esc_html($value) ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($label): ?>
                            <span style="font-family:var(--font-mono);font-size:11px;font-weight:500;line-height:1.35;letter-spacing:0.18em;text-transform:uppercase;color:<?= $is_dark ? 'oklch(60% 0.005 286)' : 'var(--fg-tertiary)' ?>;">
                                <?= esc_html($label) ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($footnote): ?>
                            <span style="font-size:13px;line-height:1.55;color:<?= $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)' ?>;max-width:280px;">
                                <?= esc_html($footnote) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div style="border:1px solid var(--border-subtle,#E2DDD2);border-radius:14px;padding:32px;display:flex;flex-direction:column;gap:10px;">
                        <?php if ($value !== ''): ?>
                            <span style="font-family:'Aeonik Fono',monospace;font-size:48px;line-height:1;font-weight:600;letter-spacing:-0.03em;color:var(--ignite-500);">
                                <?= esc_html($value) ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($label): ?>
                            <span style="font-size:15px;font-weight:500;line-height:1.35;">
                                <?= esc_html($label) ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($footnote): ?>
                            <span style="font-size:12px;line-height:1.45;color:var(--fg-secondary,#5A5A60);">
                                <?= esc_html($footnote) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
