<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$eyebrow = get_sub_field('eyebrow') ?: '';
$logos   = get_sub_field('logos') ?: [];
$variant = iiq_section_variant();
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?> >
    <div style="position:relative;max-width:1320px;margin:0 auto;text-align:center;">
        <?php iiq_section_marker(); ?>

        <?php if ($eyebrow): ?>
            <div style="margin-bottom:32px;">
                <?php iiq_section_eyebrow($eyebrow); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($logos) && is_array($logos)): ?>
            <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:48px 64px;opacity:0.85;">
                <?php foreach ($logos as $logo):
                    $img = isset($logo['image']) ? $logo['image'] : null;
                    $alt = isset($logo['alt']) && $logo['alt'] !== '' ? $logo['alt'] : (is_array($img) && !empty($img['alt']) ? $img['alt'] : '');
                    $url = isset($logo['url']) ? $logo['url'] : '';
                    if (!is_array($img) || empty($img['ID'])) continue;
                    $img_html = wp_get_attachment_image(
                        (int) $img['ID'],
                        'medium',
                        false,
                        [
                            'alt' => esc_attr($alt),
                            'style' => 'max-height:36px;width:auto;display:block;filter:grayscale(100%);opacity:0.75;transition:opacity .2s,filter .2s;',
                        ]
                    );
                    if ($url):
                ?>
                    <a href="<?= esc_url($url) ?>" rel="noopener" style="display:inline-block;line-height:0;">
                        <?= $img_html ?>
                    </a>
                <?php else: ?>
                    <span style="display:inline-block;line-height:0;"><?= $img_html ?></span>
                <?php endif; endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
