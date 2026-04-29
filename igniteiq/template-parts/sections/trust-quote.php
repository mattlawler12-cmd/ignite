<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$quote              = get_sub_field('quote') ?: '';
$attribution_role   = get_sub_field('attribution_role') ?: '';
$attribution_status = get_sub_field('attribution_status') ?: '';

// Default to dark variant for the BigQuote feel; honor _settings.theme_variant if set.
$variant = iiq_section_variant();
if (!$variant) $variant = 'dark';
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:1100px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <?php if ($quote): ?>
            <blockquote style="margin:0;padding:0;border:0;font-family:'Aeonik Fono',monospace;font-weight:500;font-size:clamp(28px,4.4vw,52px);line-height:1.18;letter-spacing:-0.02em;">
                <span aria-hidden="true" style="color:var(--ignite-500);margin-right:0.15em;">&ldquo;</span><?= wp_kses_post($quote) ?><span aria-hidden="true" style="color:var(--ignite-500);">&rdquo;</span>
            </blockquote>
        <?php endif; ?>

        <?php if ($attribution_role || $attribution_status): ?>
            <div style="margin-top:40px;display:flex;align-items:center;gap:14px;font-family:'Aeonik Fono',monospace;font-size:12px;letter-spacing:0.14em;text-transform:uppercase;opacity:0.85;">
                <?php if ($attribution_role): ?>
                    <span><?= esc_html($attribution_role) ?></span>
                <?php endif; ?>
                <?php if ($attribution_role && $attribution_status): ?>
                    <span style="width:24px;height:1px;background:var(--ignite-500);opacity:0.6;"></span>
                <?php endif; ?>
                <?php if ($attribution_status): ?>
                    <span style="color:var(--ignite-500);"><?= esc_html($attribution_status) ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
