<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

/**
 * Stacked prose + diagram section.
 *
 * Mirrors the export's ArchTwoHalves component (Architecture.js lines 154-189):
 * a vertical stack of headline -> paragraph -> full-width diagram. Used for
 * the "Your warehouse holds your data" how-it-works moment.
 *
 * Differs from split.php (2-column heading-left/diagram-right) and from
 * prose.php (text-only) in that the diagram sits BELOW the prose at the
 * full container width with a 56px top margin.
 */

$eyebrow      = get_sub_field('eyebrow') ?: '';
$headline     = get_sub_field('headline') ?: '';
$body         = get_sub_field('body') ?: '';
$diagram_type = get_sub_field('diagram_type') ?: '';
$variant      = iiq_section_variant();
$is_dark      = ($variant === 'dark');
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:1320px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <?php iiq_section_eyebrow($eyebrow); ?>

        <?php if ($headline): ?>
            <h2 style="margin:<?= $eyebrow ? '18px' : '0' ?> 0 0;font-family:var(--font-display);font-size:clamp(40px,5.6vw,76px);font-weight:600;letter-spacing:-0.04em;line-height:0.98;max-width:1100px;color:<?= $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>;">
                <?= wp_kses_post($headline) ?>
            </h2>
        <?php endif; ?>

        <?php if ($body): ?>
            <p style="margin:32px 0 0;max-width:880px;font-size:19px;line-height:1.55;color:<?= $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)' ?>;text-wrap:pretty;">
                <?= wp_kses_post($body) ?>
            </p>
        <?php endif; ?>

        <?php
        if ($diagram_type) {
            $slug = sanitize_key($diagram_type);
            if (locate_template('template-parts/diagrams/' . $slug . '.php')) {
                ?>
                <div style="margin-top:56px;">
                    <?php get_template_part('template-parts/diagrams/' . $slug); ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>
