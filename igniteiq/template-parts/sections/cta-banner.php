<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$eyebrow       = get_sub_field('eyebrow') ?: '';
$headline      = get_sub_field('headline') ?: '';
$body          = get_sub_field('body') ?: '';
$primary_cta   = get_sub_field('primary_cta');
$secondary_cta = get_sub_field('secondary_cta');
$variant       = get_sub_field('variant') ?: '';

// Map cta-banner's local variant to a section style; fall back to _settings if unset.
$resolved_variant = $variant ?: iiq_section_variant();
if (!$resolved_variant) $resolved_variant = 'dark';

$is_dark = ($resolved_variant === 'dark');
$btn_primary_style = $is_dark
    ? 'background:var(--ignite-500);color:#fff;border:1px solid var(--ignite-500);'
    : 'background:var(--ink-1000,#0F0F12);color:#fff;border:1px solid var(--ink-1000,#0F0F12);';
$btn_secondary_style = $is_dark
    ? 'background:transparent;color:#fff;border:1px solid rgba(255,255,255,0.35);'
    : 'background:transparent;color:var(--ink-1000,#0F0F12);border:1px solid var(--border-subtle,#C9C5BD);';

// Match export ArchCTA: padding '160px 32px' (160 top + 160 bottom),
// not section default (120/140). Inline overrides win against utility class.
$variant_attr = iiq_section_variant_style($resolved_variant);
if ($variant_attr === '') {
    $cta_pad_attr = ' style="padding-top:160px;padding-bottom:160px;"';
} else {
    // Splice padding overrides into existing inline style attribute.
    $cta_pad_attr = preg_replace(
        '/style="/',
        'style="padding-top:160px;padding-bottom:160px;',
        $variant_attr,
        1
    );
}
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= $cta_pad_attr ?>>
    <div style="position:relative;max-width:960px;margin:0 auto;text-align:center;">
        <?php iiq_section_marker(); ?>

        <?php if ($eyebrow): ?>
            <div style="display:flex;justify-content:center;font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:<?= $is_dark ? 'var(--ignite-400)' : 'var(--ignite-500)' ?>;margin:0 0 8px;">
                <?= esc_html($eyebrow) ?>
            </div>
        <?php endif; ?>

        <?php if ($headline): ?>
            <h2 class="iiq-display-xl" style="margin:0 0 24px;font-family:'Aeonik Fono',monospace;font-weight:600;letter-spacing:-0.025em;line-height:1.02;">
                <?= wp_kses_post($headline) ?>
            </h2>
        <?php endif; ?>
        <?php if ($body): ?>
            <div style="margin:0 auto 40px;max-width:640px;font-size:18px;line-height:1.55;opacity:0.85;">
                <?= wp_kses_post($body) ?>
            </div>
        <?php endif; ?>

        <div style="display:inline-flex;flex-wrap:wrap;gap:14px;justify-content:center;">
            <?php
            $render_cta = function($cta, $style) {
                if (!is_array($cta)) return;
                $label = isset($cta['label']) ? $cta['label'] : '';
                $url   = isset($cta['url']) ? $cta['url'] : '';
                if (!$label || !$url) return;
                ?>
                <a href="<?= esc_url($url) ?>" style="<?= esc_attr($style) ?>display:inline-flex;align-items:center;gap:10px;padding:16px 28px;border-radius:999px;font-family:'Aeonik Fono',monospace;font-size:14px;letter-spacing:0.04em;text-transform:uppercase;text-decoration:none;font-weight:500;transition:transform .15s ease,opacity .15s ease;">
                    <?= esc_html($label) ?>
                    <span aria-hidden="true">&rarr;</span>
                </a>
                <?php
            };
            $render_cta($primary_cta, $btn_primary_style);
            $render_cta($secondary_cta, $btn_secondary_style);
            ?>
        </div>
    </div>
</section>
