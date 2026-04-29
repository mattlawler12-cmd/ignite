<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

/**
 * Two-column contrast table section.
 * Ports the JSX ArchHeadless contrast block: eyebrow + headline + 2-col body
 * paragraphs + bordered N-row comparison table.
 */

$eyebrow      = get_sub_field('eyebrow') ?: '';
$headline     = get_sub_field('headline') ?: '';
$headline_accent = get_sub_field('headline_accent') ?: ''; // optional muted-color tail
$body_left    = get_sub_field('body_left') ?: '';
$body_right   = get_sub_field('body_right') ?: '';
$header_old   = get_sub_field('table_header_old') ?: 'The old model';
$header_new   = get_sub_field('table_header_new') ?: 'The new model';
$rows         = get_sub_field('rows') ?: [];
$variant      = iiq_section_variant();
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:1320px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <?php iiq_section_eyebrow($eyebrow); ?>

        <?php if ($headline || $headline_accent): ?>
            <h2 class="iiq-display-lg" style="margin:24px 0 0;font-family:var(--font-display,'Aeonik',sans-serif);font-size:clamp(40px,5.6vw,76px);font-weight:600;letter-spacing:-0.04em;line-height:0.98;max-width:1180px;color:var(--fg-primary);">
                <?= wp_kses_post($headline) ?><?php if ($headline_accent): ?><span style="color:var(--fg-tertiary);"> <?= wp_kses_post($headline_accent) ?></span><?php endif; ?>
            </h2>
        <?php endif; ?>

        <?php if ($body_left || $body_right): ?>
            <div class="iiq-grid-2" style="margin-top:56px;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:flex-start;">
                <?php if ($body_left): ?>
                    <div style="margin:0;font-size:19px;line-height:1.55;color:var(--fg-secondary);text-wrap:pretty;">
                        <?= wp_kses_post($body_left) ?>
                    </div>
                <?php endif; ?>
                <?php if ($body_right): ?>
                    <div style="margin:0;font-size:17px;line-height:1.6;color:var(--fg-secondary);text-wrap:pretty;">
                        <?= wp_kses_post($body_right) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($rows) && is_array($rows)): ?>
            <div style="margin-top:96px;max-width:880px;margin-left:auto;margin-right:auto;border:1px solid var(--border-default);background:var(--bg-canvas);">
                <!-- Header row -->
                <div style="display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid var(--border-default);">
                    <div style="padding:20px 28px;font-family:'Aeonik Fono',monospace;font-weight:600;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);border-right:1px solid var(--border-default);font-size:14px;line-height:1.2;">
                        <?= esc_html($header_old) ?>
                    </div>
                    <div style="padding:20px 28px;font-family:'Aeonik Fono',monospace;font-weight:600;letter-spacing:0.18em;text-transform:uppercase;color:var(--ignite-500);font-size:14px;line-height:1.2;">
                        <?= esc_html($header_new) ?>
                    </div>
                </div>

                <?php $last = count($rows) - 1; foreach ($rows as $i => $row):
                    $old_text = is_array($row) ? ($row['old_text'] ?? '') : '';
                    $new_text = is_array($row) ? ($row['new_text'] ?? '') : '';
                ?>
                    <div style="display:grid;grid-template-columns:1fr 1fr;<?= $i === $last ? '' : 'border-bottom:1px solid var(--border-subtle);' ?>align-items:center;">
                        <div style="padding:16px 28px;font-size:16px;line-height:1.4;color:var(--fg-tertiary);border-right:1px solid var(--border-default);">
                            <?= esc_html($old_text) ?>
                        </div>
                        <div style="padding:16px 28px;font-size:16px;line-height:1.4;color:var(--fg-primary);font-weight:500;">
                            <?= esc_html($new_text) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
