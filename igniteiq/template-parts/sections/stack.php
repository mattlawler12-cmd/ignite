<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$eyebrow  = get_sub_field('eyebrow') ?: '';
$headline = get_sub_field('headline') ?: '';
$body     = get_sub_field('body') ?: '';
$items    = get_sub_field('items') ?: [];
$layout   = get_sub_field('layout') ?: 'list-2col';
$variant  = iiq_section_variant();
$is_dark  = ($variant === 'dark');
$count    = is_array($items) ? count($items) : 0;
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:1320px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <div style="max-width:880px;margin:0 0 64px;">
            <?php iiq_section_eyebrow($eyebrow); ?>
            <?php if ($headline): ?>
                <h2 class="iiq-display-lg" style="margin:18px 0 0;font-family:var(--font-display);font-weight:600;letter-spacing:-0.04em;line-height:1.0;<?= $is_dark ? 'color:var(--ink-50);' : '' ?>">
                    <?= wp_kses_post($headline) ?>
                </h2>
            <?php endif; ?>
            <?php if ($body): ?>
                <div style="margin-top:22px;font-size:19px;line-height:1.55;color:<?= $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)' ?>;max-width:760px;">
                    <?= wp_kses_post($body) ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($items) && is_array($items)): ?>
            <?php if ($layout === 'timeline-horizontal' && $count > 0): ?>
                <div style="position:relative;margin-top:24px;">
                    <div aria-hidden="true" style="position:absolute;top:28px;left:0;right:0;height:1px;background:<?= $is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)' ?>;"></div>
                    <div style="display:grid;grid-template-columns:repeat(<?= (int) $count ?>,1fr);gap:0;">
                        <?php foreach ($items as $i => $item):
                            $step  = isset($item['step']) ? $item['step'] : '';
                            $title = isset($item['title']) ? $item['title'] : '';
                            $b     = isset($item['body']) ? $item['body'] : '';
                            $is_last = ($i === $count - 1);
                        ?>
                            <div style="position:relative;padding:24px 24px 28px;<?= !$is_last ? 'border-right:1px solid ' . ($is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-subtle,#E2DDD2)') . ';' : '' ?>">
                                <span aria-hidden="true" style="position:absolute;top:23px;left:24px;width:10px;height:10px;border-radius:50%;background:var(--ignite-500);box-shadow:0 0 0 4px oklch(57.5% 0.232 25 / 0.15);"></span>
                                <div style="margin-top:32px;font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--ignite-500);">
                                    <?= esc_html($step) ?>
                                </div>
                                <?php if ($title): ?>
                                    <h3 style="font-family:var(--font-display);font-size:22px;font-weight:600;letter-spacing:-0.02em;line-height:1.2;margin:10px 0 8px;color:<?= $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>;">
                                        <?= esc_html($title) ?>
                                    </h3>
                                <?php endif; ?>
                                <?php if ($b): ?>
                                    <p style="font-size:14px;line-height:1.5;color:<?= $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)' ?>;margin:0;">
                                        <?= wp_kses_post($b) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($layout === 'grid-3col'): ?>
                <div style="display:flex;flex-direction:column;border-top:1px solid <?= $is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)' ?>;">
                    <?php foreach ($items as $i => $item):
                        $step  = isset($item['step']) ? $item['step'] : '';
                        $title = isset($item['title']) ? $item['title'] : '';
                        $b     = isset($item['body']) ? $item['body'] : '';
                        $is_last = ($i === $count - 1);
                    ?>
                        <div style="display:grid;grid-template-columns:180px 1fr 1.6fr;gap:56px;padding:36px 0;<?= $is_last ? 'border-bottom:1px solid ' . ($is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)') . ';' : 'border-bottom:1px solid ' . ($is_dark ? 'oklch(20% 0.005 286)' : 'var(--border-subtle,#E2DDD2)') . ';' ?>align-items:start;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span aria-hidden="true" style="width:6px;height:6px;border-radius:999px;background:var(--ignite-500);"></span>
                                <span style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--ignite-500);font-weight:500;">
                                    <?= esc_html($step) ?>
                                </span>
                            </div>
                            <?php if ($title): ?>
                                <h3 style="font-family:var(--font-display);font-size:26px;font-weight:600;letter-spacing:-0.025em;line-height:1.15;margin:0;color:<?= $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>;">
                                    <?= esc_html($title) ?>
                                </h3>
                            <?php endif; ?>
                            <?php if ($b): ?>
                                <p style="font-size:15px;line-height:1.6;color:<?= $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)' ?>;margin:0;">
                                    <?= wp_kses_post($b) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: // list-2col (default) ?>
                <ol style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:0;border-top:1px solid var(--border-subtle,#E2DDD2);">
                    <?php foreach ($items as $i => $item):
                        $step  = isset($item['step']) && $item['step'] !== ''
                            ? $item['step']
                            : str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT);
                        $title = isset($item['title']) ? $item['title'] : '';
                        $b     = isset($item['body']) ? $item['body'] : '';
                    ?>
                        <li style="display:grid;grid-template-columns:120px 1fr;gap:32px;padding:28px 0;border-bottom:1px solid var(--border-subtle,#E2DDD2);align-items:start;">
                            <span style="font-family:var(--font-mono);font-size:13px;letter-spacing:0.14em;color:var(--ignite-500);padding-top:4px;">
                                <?= esc_html($step) ?>
                            </span>
                            <div>
                                <?php if ($title): ?>
                                    <h3 style="margin:0 0 8px;font-family:var(--font-display);font-size:22px;line-height:1.25;font-weight:600;letter-spacing:-0.01em;<?= $is_dark ? 'color:var(--ink-50);' : '' ?>">
                                        <?= esc_html($title) ?>
                                    </h3>
                                <?php endif; ?>
                                <?php if ($b): ?>
                                    <div style="font-size:16px;line-height:1.6;color:<?= $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)' ?>;max-width:720px;">
                                        <?= wp_kses_post($b) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
