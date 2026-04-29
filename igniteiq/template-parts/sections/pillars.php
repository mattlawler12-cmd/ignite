<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$eyebrow        = get_sub_field('eyebrow') ?: '';
$headline       = get_sub_field('headline') ?: '';
$headline_lead  = get_sub_field('headline_lead') ?: '';
$headline_gap   = get_sub_field('headline_gap') ?: '';
$headline_break = (bool) get_sub_field('headline_break');
$intro          = get_sub_field('intro') ?: '';
$columns   = (int) (get_sub_field('columns') ?: 3);
if ($columns < 2 || $columns > 4) $columns = 3;
$style     = get_sub_field('style') ?: 'cards';
$items     = get_sub_field('items') ?: [];
$scenarios = get_sub_field('scenarios') ?: [];
$variant   = iiq_section_variant();
$is_dark   = ($variant === 'dark');
?>
<section class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:1320px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <div style="max-width:880px;margin:0 auto 64px;text-align:center;">
            <?php iiq_section_eyebrow($eyebrow); ?>
            <?php if ($headline_lead && $headline_gap): ?>
                <h2 class="iiq-display-lg" style="margin:18px 0 0;font-family:var(--font-display);font-weight:600;letter-spacing:-0.035em;line-height:1.05;<?= $is_dark ? 'color:var(--ink-50);' : '' ?>">
                    <?= wp_kses_post($headline_lead) ?><?php if ($headline_break): ?><br><span style="color:var(--fg-tertiary);"><?= wp_kses_post($headline_gap) ?></span><?php else: ?><span style="color:var(--fg-tertiary);">&nbsp;<?= wp_kses_post($headline_gap) ?></span><?php endif; ?>
                </h2>
            <?php elseif ($headline): ?>
                <h2 class="iiq-display-lg" style="margin:18px 0 0;font-family:var(--font-display);font-weight:600;letter-spacing:-0.035em;line-height:1.05;<?= $is_dark ? 'color:var(--ink-50);' : '' ?>">
                    <?= wp_kses_post($headline) ?>
                </h2>
            <?php endif; ?>
            <?php if ($intro): ?>
                <div style="margin-top:22px;font-size:18px;line-height:1.55;color:<?= $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)' ?>;">
                    <?= wp_kses_post($intro) ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($items) && is_array($items)):
            // Resolve container + item styles per style variant.
            $container_style = 'display:grid;grid-template-columns:repeat(' . $columns . ',1fr);';
            $item_style = '';
            $title_color = $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)';
            $body_color  = $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)';
            $idx_color   = $is_dark ? 'var(--ignite-400)' : 'var(--ignite-500)';

            switch ($style) {
                case 'bars':
                    $container_style .= 'gap:64px;align-items:stretch;margin-top:120px;';
                    break;
                case 'bordered':
                    $container_style .= 'gap:0;border-top:1px solid ' . ($is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)') . ';border-bottom:1px solid ' . ($is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)') . ';';
                    break;
                case 'top-border':
                    $container_style .= 'gap:48px;';
                    break;
                case 'grid-divided':
                    $container_style .= 'gap:1px;background:' . ($is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)') . ';border:1px solid ' . ($is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)') . ';';
                    break;
                case 'cards':
                default:
                    $container_style .= 'gap:28px;';
                    break;
            }
        ?>
            <div style="<?= esc_attr($container_style) ?>">
                <?php foreach ($items as $i => $item):
                    $title  = isset($item['title']) ? $item['title'] : '';
                    $body   = isset($item['body']) ? $item['body'] : '';
                    $idxnum = isset($item['index_number']) && $item['index_number'] !== ''
                        ? $item['index_number']
                        : str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT);
                    $is_last = ($i === count($items) - 1);
                    // Per-card reveal w/ staggered delay — mirrors export pattern
                    // (each card wrapped in its own <Reveal delay={i*N}>) and avoids
                    // section-level opacity transition causing layout to read narrow
                    // mid-fade on screenshots.
                    $reveal_delay = $i * 100;
                    $reveal_attrs = ' data-reveal data-reveal-delay="' . $reveal_delay . '"';
                ?>
                <?php if ($style === 'bars'): ?>
                    <article<?= $reveal_attrs ?> style="display:flex;flex-direction:column;height:100%;">
                        <svg aria-hidden="true" viewBox="0 0 1000 16" preserveAspectRatio="none" style="display:block;width:100%;height:12px;">
                            <polygon points="0,14 14,2 986,2 1000,14" fill="<?= $is_dark ? 'var(--ink-50)' : 'var(--ink-1000,#0F0F12)' ?>"/>
                        </svg>
                        <div style="display:flex;align-items:center;gap:16px;margin-top:36px;">
                            <span style="font-family:var(--font-mono);font-size:12px;letter-spacing:0.18em;color:<?= $is_dark ? 'oklch(60% 0.005 286)' : 'var(--fg-tertiary)' ?>;font-weight:500;"><?= esc_html($idxnum) ?></span>
                            <span style="flex:1;height:1px;background:<?= $is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-subtle)' ?>;"></span>
                        </div>
                        <?php if ($title): ?>
                            <h3 style="font-family:var(--font-display);font-size:26px;font-weight:700;letter-spacing:-0.02em;line-height:1.15;margin:28px 0 16px;color:<?= $title_color ?>;text-transform:uppercase;">
                                <?= esc_html($title) ?>
                            </h3>
                        <?php endif; ?>
                        <?php if ($body): ?>
                            <p style="font-size:16px;line-height:1.55;color:<?= $body_color ?>;margin:0;text-wrap:pretty;max-width:360px;">
                                <?= wp_kses_post($body) ?>
                            </p>
                        <?php endif; ?>
                        <div style="flex:1;min-height:56px;"></div>
                        <svg aria-hidden="true" viewBox="0 0 1000 16" preserveAspectRatio="none" style="display:block;width:100%;height:12px;">
                            <polygon points="0,14 14,2 986,2 1000,14" fill="<?= $is_dark ? 'var(--ink-50)' : 'var(--ink-1000,#0F0F12)' ?>"/>
                        </svg>
                    </article>

                <?php elseif ($style === 'bordered'): ?>
                    <article<?= $reveal_attrs ?> style="padding:40px 32px 8px;<?= $i > 0 ? 'border-left:1px solid ' . ($is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)') . ';' : '' ?>">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                            <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:<?= $idx_color ?>;"></span>
                            <span style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:<?= $idx_color ?>;font-weight:500;"><?= esc_html($idxnum) ?> &mdash; <?= esc_html($title) ?></span>
                        </div>
                        <?php if ($title): ?>
                            <h3 style="font-family:var(--font-display);font-size:36px;font-weight:600;letter-spacing:-0.025em;line-height:1.05;margin:0 0 16px;color:<?= $title_color ?>;">
                                <?= esc_html($title) ?>
                            </h3>
                        <?php endif; ?>
                        <?php if ($body): ?>
                            <p style="font-size:16px;line-height:1.6;color:<?= $body_color ?>;margin:0 0 32px;">
                                <?= wp_kses_post($body) ?>
                            </p>
                        <?php endif; ?>
                    </article>

                <?php elseif ($style === 'top-border'): ?>
                    <article<?= $reveal_attrs ?> style="border-top:1px solid <?= $is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)' ?>;padding-top:28px;display:flex;flex-direction:column;gap:14px;">
                        <span style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;color:<?= $idx_color ?>;font-weight:500;"><?= esc_html($idxnum) ?></span>
                        <?php if ($title): ?>
                            <h3 style="font-family:var(--font-display);font-size:28px;font-weight:600;letter-spacing:-0.025em;line-height:1.15;margin:0;color:<?= $title_color ?>;">
                                <?= esc_html($title) ?>
                            </h3>
                        <?php endif; ?>
                        <?php if ($body): ?>
                            <p style="font-size:15px;line-height:1.6;color:<?= $body_color ?>;margin:0;">
                                <?= wp_kses_post($body) ?>
                            </p>
                        <?php endif; ?>
                    </article>

                <?php elseif ($style === 'grid-divided'): ?>
                    <article<?= $reveal_attrs ?> style="background:<?= $is_dark ? 'var(--ink-1000)' : '#fff' ?>;padding:32px 28px;display:flex;flex-direction:column;gap:14px;height:100%;">
                        <span style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.14em;color:<?= $idx_color ?>;"><?= esc_html($idxnum) ?></span>
                        <?php if ($title): ?>
                            <h3 style="font-family:var(--font-display);font-size:18px;font-weight:600;letter-spacing:-0.01em;line-height:1.2;margin:0;color:<?= $title_color ?>;">
                                <?= esc_html($title) ?>
                            </h3>
                        <?php endif; ?>
                        <?php if ($body): ?>
                            <p style="font-size:14px;line-height:1.55;color:<?= $body_color ?>;margin:0;">
                                <?= wp_kses_post($body) ?>
                            </p>
                        <?php endif; ?>
                    </article>

                <?php else: // cards (default) ?>
                    <article<?= $reveal_attrs ?> style="background:var(--bg-canvas,#fff);border:1px solid var(--border-subtle,#E2DDD2);border-radius:14px;padding:32px;display:flex;flex-direction:column;gap:14px;">
                        <span style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.14em;color:<?= $idx_color ?>;">
                            <?= esc_html($idxnum) ?>
                        </span>
                        <?php if ($title): ?>
                            <h3 style="margin:0;font-family:var(--font-display);font-size:22px;line-height:1.2;font-weight:600;letter-spacing:-0.01em;color:<?= $title_color ?>;">
                                <?= esc_html($title) ?>
                            </h3>
                        <?php endif; ?>
                        <?php if ($body): ?>
                            <div style="font-size:15px;line-height:1.6;color:<?= $body_color ?>;">
                                <?= wp_kses_post($body) ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php
        // FIDELITY: bars-style sections in the export do not render scenarios.
        // SectionsA.js WhatChangesSection (lines 286-429) defines a `scenarios`
        // array but its JSX return only renders `values.map`. InvestInOutcomes.js
        // InvestInOutcomesSection has no scenarios at all. Data is preserved in
        // cli.php seed per "do not throw anything away" — we just skip the render.
        ?>
        <?php if ($style !== 'bars' && !empty($scenarios) && is_array($scenarios)): ?>
            <div style="margin-top:48px;display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
                <?php foreach ($scenarios as $sc):
                    $sc_tag  = isset($sc['tag']) ? $sc['tag'] : '';
                    $sc_body = isset($sc['body']) ? $sc['body'] : '';
                ?>
                    <article style="background:var(--bg-sunken,#F4EFE4);border:1px solid var(--border-subtle,#E2DDD2);border-radius:12px;padding:22px 24px;display:flex;flex-direction:column;gap:10px;">
                        <?php if ($sc_tag): ?>
                            <span style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:var(--ignite-500);"><?= esc_html($sc_tag) ?></span>
                        <?php endif; ?>
                        <?php if ($sc_body): ?>
                            <p style="margin:0;font-size:14px;line-height:1.55;color:var(--fg-secondary,#5A5A60);"><?= wp_kses_post($sc_body) ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
