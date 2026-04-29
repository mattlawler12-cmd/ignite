<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$eyebrow     = get_sub_field('eyebrow') ?: '';
$headline    = get_sub_field('headline') ?: '';
$body        = get_sub_field('body') ?: '';
$media_slot  = get_sub_field('media_slot') ?: 'diagram';
$diagram_key = get_sub_field('diagram_key') ?: '';
$image       = get_sub_field('image');
$reverse     = (bool) get_sub_field('reverse');
$variant     = iiq_section_variant();

// Optional asymmetric grid ratio sourced from _settings.column_ratio.
// Defaults to '1fr 1fr' so existing split sections render unchanged.
// Use the shared resolver — `_settings` (underscore-prefixed) is filtered
// out by ACF's `get_sub_field()` and must be retrieved by field key.
$_split_settings = iiq_section_settings();
$column_ratio    = is_array($_split_settings) && !empty($_split_settings['column_ratio'])
    ? (string) $_split_settings['column_ratio']
    : '1fr 1fr';

$text_order  = $reverse ? 2 : 1;
$media_order = $reverse ? 1 : 2;
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:1320px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <div class="iiq-grid-split" style="display:grid;grid-template-columns:<?= esc_attr($column_ratio) ?>;gap:80px;align-items:center;">
            <div style="order:<?= (int) $text_order ?>;">
                <?php iiq_section_eyebrow($eyebrow); ?>
                <?php if ($headline): ?>
                    <h2 class="iiq-display-lg" style="margin:18px 0 24px;font-family:'Aeonik Fono',monospace;font-weight:600;letter-spacing:-0.02em;line-height:1.05;">
                        <?= wp_kses_post($headline) ?>
                    </h2>
                <?php endif; ?>
                <?php if ($body): ?>
                    <div style="font-size:17px;line-height:1.6;color:var(--fg-secondary,#5A5A60);">
                        <?= wp_kses_post($body) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div style="order:<?= (int) $media_order ?>;">
                <?php
                if ($media_slot === 'diagram' && $diagram_key) {
                    $slug = sanitize_key($diagram_key);
                    if (locate_template('template-parts/diagrams/' . $slug . '.php')) {
                        get_template_part('template-parts/diagrams/' . $slug);
                    }
                } elseif ($media_slot === 'image' && is_array($image) && !empty($image['ID'])) {
                    echo wp_get_attachment_image(
                        (int) $image['ID'],
                        'large',
                        false,
                        ['style' => 'width:100%;height:auto;border-radius:14px;display:block;']
                    );
                }
                ?>
            </div>
        </div>
    </div>
</section>
