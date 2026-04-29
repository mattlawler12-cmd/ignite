<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$eyebrow        = get_sub_field('eyebrow') ?: '';
$headline       = get_sub_field('headline') ?: '';
$headline_lead  = get_sub_field('headline_lead') ?: '';
$headline_gap   = get_sub_field('headline_gap') ?: '';
$headline_break = (bool) get_sub_field('headline_break');
$headline_align = get_sub_field('headline_align') ?: 'center';
$intro          = get_sub_field('intro') ?: '';
$columns   = (int) (get_sub_field('columns') ?: 3);
if ($columns < 2 || $columns > 4) $columns = 3;
$style     = get_sub_field('style') ?: 'cards';
$items     = get_sub_field('items') ?: [];
$scenarios = get_sub_field('scenarios') ?: [];
$compact_top = (bool) get_sub_field('compact_top');
$hide_index  = (bool) get_sub_field('hide_index');
$variant   = iiq_section_variant();
$is_dark   = ($variant === 'dark');
// FIDELITY: compact_top=true zeroes the section's top padding so the
// section visually continues from the previous one (used when a single
// export component was split into two ACF flex rows — e.g. Ontology
// CoreEntities, where section_stats + section_pillars together
// represent one block).
$variant_attr = iiq_section_variant_style($variant);
if ($compact_top) {
    if ($variant_attr === '') {
        $variant_attr = ' style="padding-top:0;"';
    } else {
        $variant_attr = preg_replace('/style="/', 'style="padding-top:0;', $variant_attr, 1);
    }
}
?>
<section class="iiq-pad iiq-section-pad"<?= $variant_attr ?>>
    <div style="position:relative;max-width:1320px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <?php
        // FIDELITY: headline_align controls the introductory block.
        // 'center' (default) → max-width 880, centered (matches WhatChanges,
        //   Invest, "Great decisions"-style centered intros).
        // 'left'   → max-width 1100, left-aligned (matches Ontology
        //   WhyHomeServices: "Generic ontologies don't know what a callback
        //   costs you." — Ontology.js lines 197-220).
        $intro_block_style = ($headline_align === 'left')
            ? 'max-width:1100px;margin:0 0 80px;text-align:left;'
            : 'max-width:880px;margin:0 auto 64px;text-align:center;';
        ?>
        <div style="<?= esc_attr($intro_block_style) ?>">
            <?php iiq_section_eyebrow($eyebrow); ?>
            <?php
            // H2 typography varies by alignment. Left-aligned (Ontology
            // WhyHomeServices, Great decisions) uses clamp(44, 5.6vw, 88px),
            // letter-spacing -0.04em, line-height 0.98, max-width 1100.
            // Centered (WhatChanges, Invest) keeps the iiq-display-lg defaults.
            $h2_style = ($headline_align === 'left')
                ? 'margin:64px 0 0;font-family:var(--font-display);font-size:clamp(44px,5.6vw,88px);font-weight:600;letter-spacing:-0.04em;line-height:0.98;max-width:1100px;'
                : 'margin:18px 0 0;font-family:var(--font-display);font-weight:600;letter-spacing:-0.035em;line-height:1.05;';
            $h2_style .= $is_dark ? 'color:var(--ink-50);' : '';
            $h2_class = ($headline_align === 'left') ? '' : 'iiq-display-lg';
            // For dark sections the gap span uses a desaturated medium-gray
            // (oklch 55%) instead of the light-mode --fg-tertiary token.
            $gap_color = $is_dark ? 'oklch(55% 0.005 286)' : 'var(--fg-tertiary)';
            ?>
            <?php if ($headline_lead && $headline_gap): ?>
                <h2 class="<?= esc_attr($h2_class) ?>" style="<?= esc_attr($h2_style) ?>">
                    <?= wp_kses_post($headline_lead) ?><?php if ($headline_break): ?><br><span style="color:<?= esc_attr($gap_color) ?>;"><?= wp_kses_post($headline_gap) ?></span><?php else: ?><span style="color:<?= esc_attr($gap_color) ?>;">&nbsp;<?= wp_kses_post($headline_gap) ?></span><?php endif; ?>
                </h2>
            <?php elseif ($headline): ?>
                <h2 class="<?= esc_attr($h2_class) ?>" style="<?= esc_attr($h2_style) ?>">
                    <?= wp_kses_post($headline) ?>
                </h2>
            <?php endif; ?>
            <?php if ($intro): ?>
                <div style="margin-top:32px;font-size:<?= $headline_align === 'left' ? '19' : '18' ?>px;line-height:1.55;<?= $headline_align === 'left' ? 'max-width:880px;' : '' ?>color:<?= $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)' ?>;">
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
                    // Dark variant: just borderTop (matches Ontology
                    // WhyHomeServices, Ontology.js:226). Light variant: top
                    // and bottom rules (matches "Great decisions" pattern).
                    if ($is_dark) {
                        $container_style .= 'gap:0;margin-top:80px;border-top:1px solid oklch(22% 0.005 286);';
                    } else {
                        $container_style .= 'gap:0;border-top:1px solid var(--border-default,#C9C5BD);border-bottom:1px solid var(--border-default,#C9C5BD);';
                    }
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

                <?php elseif ($style === 'bordered'):
                    // FIDELITY: per-card eyebrow renders just `● 01` when no
                    // explicit `eyebrow_label` is set on the item — matches
                    // Ontology WhyHomeServices cards (Ontology.js 246).
                    // When `eyebrow_label` IS set (e.g. Ontology Great
                    // decisions cards: "01 — Data"), the dash + label is
                    // appended (Ontology.js 144-151).
                    $eyebrow_label = isset($item['eyebrow_label']) ? $item['eyebrow_label'] : '';
                    // First-card border: in left-aligned/dark sections the
                    // export uses NO outer side padding on the first/last cards
                    // and a borderLeft between cards.
                    $first_pad_left  = ($i === 0) ? '0' : '32px';
                    $last_pad_right  = ($i === count($items) - 1) ? '0' : '32px';
                ?>
                    <article<?= $reveal_attrs ?> style="padding:40px <?= $last_pad_right ?> 8px <?= $first_pad_left ?>;<?= $i > 0 ? 'border-left:1px solid ' . ($is_dark ? 'oklch(22% 0.005 286)' : 'var(--border-default,#C9C5BD)') . ';' : '' ?>">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                            <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:<?= $idx_color ?>;"></span>
                            <span style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:<?= $idx_color ?>;font-weight:500;"><?= esc_html($idxnum) ?><?php if ($eyebrow_label): ?> &mdash; <?= esc_html($eyebrow_label) ?><?php endif; ?></span>
                        </div>
                        <?php if ($title): ?>
                            <h3 style="font-family:var(--font-display);font-size:<?= $is_dark ? '24' : '36' ?>px;font-weight:600;letter-spacing:-0.025em;line-height:<?= $is_dark ? '1.15' : '1.05' ?>;margin:<?= $is_dark ? '20px 0 24px' : '0 0 16px' ?>;color:<?= $title_color ?>;">
                                <?= esc_html($title) ?>
                            </h3>
                        <?php endif; ?>
                        <?php if ($body): ?>
                            <p style="font-size:<?= $is_dark ? '15' : '16' ?>px;line-height:<?= $is_dark ? '1.6' : '1.6' ?>;color:<?= $body_color ?>;margin:<?= $is_dark ? '18px 0 0' : '0 0 32px' ?>;">
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
                    <article<?= $reveal_attrs ?> style="background:<?= $is_dark ? 'var(--ink-1000)' : '#fff' ?>;padding:32px 28px;display:flex;flex-direction:column;gap:10px;height:100%;">
                        <?php if (!$hide_index): ?>
                            <span style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.14em;color:<?= $idx_color ?>;"><?= esc_html($idxnum) ?></span>
                        <?php endif; ?>
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
        $scenarios_layout = get_sub_field('scenarios_layout') ?: 'cards';
        ?>
        <?php if ($style !== 'bars' && !empty($scenarios) && is_array($scenarios) && $scenarios_layout === 'pullquote'):
            // FIDELITY: centered pull-quote with horizontal-line eyebrow + an
            // italic tertiary span on the second sentence. Mirrors Ontology.js
            // 424-477 ("─ The point ─" + "What looks like fifteen disconnected
            // systems on the surface is one business underneath. The ontology
            // is the layer where it finally acts like one.").
            $sc       = $scenarios[0];
            $sc_tag   = isset($sc['tag']) ? $sc['tag'] : '';
            $sc_body  = isset($sc['body']) ? $sc['body'] : '';
            // Split the body on the first sentence boundary so the second
            // sentence renders italic + tertiary (matches export `<em>`).
            $hpos     = strpos($sc_body, '. ');
            $sc_first = $hpos !== false ? substr($sc_body, 0, $hpos + 1) : $sc_body;
            $sc_second = $hpos !== false ? trim(substr($sc_body, $hpos + 1)) : '';
            $rule_color = $is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)';
            $tag_color  = $is_dark ? 'oklch(60% 0.005 286)' : 'var(--fg-tertiary)';
            $h3_color   = $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)';
            $em_color   = $is_dark ? 'oklch(60% 0.005 286)' : 'var(--fg-tertiary)';
        ?>
            <div style="margin-top:96px;padding-top:56px;border-top:1px solid <?= esc_attr($rule_color) ?>;display:flex;flex-direction:column;align-items:center;text-align:center;">
                <?php if ($sc_tag): ?>
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:<?= esc_attr($tag_color) ?>;">
                        <span style="width:24px;height:1px;background:<?= esc_attr($rule_color) ?>;"></span>
                        <span><?= esc_html($sc_tag) ?></span>
                        <span style="width:24px;height:1px;background:<?= esc_attr($rule_color) ?>;"></span>
                    </div>
                <?php endif; ?>
                <h3 style="margin:0;max-width:940px;font-family:var(--font-display);font-size:clamp(28px,3.4vw,44px);line-height:1.2;letter-spacing:-0.02em;font-weight:400;color:<?= esc_attr($h3_color) ?>;text-wrap:balance;">
                    <?= wp_kses_post($sc_first) ?><?php if ($sc_second): ?> <em style="font-style:italic;color:<?= esc_attr($em_color) ?>;"><?= wp_kses_post($sc_second) ?></em><?php endif; ?>
                </h3>
            </div>
        <?php elseif ($style !== 'bars' && !empty($scenarios) && is_array($scenarios)): ?>
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
