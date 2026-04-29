<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

/**
 * Gap-Split section.
 *
 * Mirrors the export's ProblemSection (SectionsA.js lines 54-181) — the
 * "Every home services business is a decision-making engine. The data
 * underneath is blurry." moment on the home page.
 *
 * Structure (asymmetric 1.1fr / 0.9fr outer grid, gap 80px):
 *   LEFT  → headline (with tertiary-colored span on the gap clause)
 *         → nested 2-col grid of two body paragraphs (gap 32px, marginTop 48px)
 *         → full-width pull-quote with 1px top border (marginTop 56px,
 *           paddingTop 32px, font-display 28px)
 *   RIGHT → diagram slot (typically operator-stack — surrounding card chrome
 *           is rendered by the diagram template itself).
 *
 * Differs from split.php (single body wysiwyg, centered align) and from
 * stacked-prose-diagram.php (vertical stack, no right column).
 */

$eyebrow            = get_sub_field('eyebrow') ?: '';
$headline_lead      = get_sub_field('headline_lead') ?: '';
$headline_gap       = get_sub_field('headline_gap') ?: '';
$body_left          = get_sub_field('body_left') ?: '';
$body_right         = get_sub_field('body_right') ?: '';
$pull_quote         = get_sub_field('pull_quote') ?: '';
$diagram_key        = get_sub_field('diagram_key') ?: '';
$variant            = iiq_section_variant();
$is_dark            = ($variant === 'dark');

$fg_primary   = $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)';
$fg_secondary = $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)';
$fg_tertiary  = $is_dark ? 'oklch(60% 0.005 286)' : 'var(--fg-tertiary)';
$border_subtle = $is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-subtle)';
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:1320px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <div class="iiq-grid-gap-split" style="display:grid;grid-template-columns:1.1fr 0.9fr;gap:80px;align-items:flex-start;">
            <div>
                <?php iiq_section_eyebrow($eyebrow); ?>

                <?php if ($headline_lead || $headline_gap): ?>
                    <h2 style="margin:<?= $eyebrow ? '18px' : '0' ?> 0 0;font-family:var(--font-display);font-size:clamp(40px,5.6vw,76px);font-weight:600;letter-spacing:-0.04em;line-height:0.98;color:<?= esc_attr($fg_primary) ?>;">
                        <?= wp_kses_post($headline_lead) ?><?php if ($headline_gap): ?><span style="color:<?= esc_attr($fg_tertiary) ?>;"> <?= wp_kses_post($headline_gap) ?></span><?php endif; ?>
                    </h2>
                <?php endif; ?>

                <?php if ($body_left || $body_right): ?>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:32px;margin-top:48px;">
                        <?php if ($body_left): ?>
                            <p style="font-size:16px;line-height:1.55;color:<?= esc_attr($fg_secondary) ?>;margin:0;">
                                <?= wp_kses_post($body_left) ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($body_right): ?>
                            <p style="font-size:16px;line-height:1.55;color:<?= esc_attr($fg_secondary) ?>;margin:0;">
                                <?= wp_kses_post($body_right) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($pull_quote): ?>
                    <p style="margin:56px 0 0;padding-top:32px;border-top:1px solid <?= esc_attr($border_subtle) ?>;font-family:var(--font-display);font-size:28px;line-height:1.2;font-weight:500;letter-spacing:-0.025em;color:<?= esc_attr($fg_primary) ?>;">
                        <?= wp_kses_post($pull_quote) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div>
                <?php
                if ($diagram_key) {
                    $slug = sanitize_key($diagram_key);
                    if (locate_template('template-parts/diagrams/' . $slug . '.php')) {
                        get_template_part('template-parts/diagrams/' . $slug);
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
