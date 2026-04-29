<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$eyebrow       = get_sub_field('eyebrow') ?: '';
$headline      = get_sub_field('headline') ?: '';
$headline_lead = get_sub_field('headline_lead') ?: '';
$headline_gap  = get_sub_field('headline_gap') ?: '';
$paragraphs    = get_sub_field('paragraphs') ?: [];
$style         = get_sub_field('style') ?: 'single';
$variant    = iiq_section_variant();
$is_dark    = ($variant === 'dark');
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <?php if ($style === 'split'): ?>
        <div style="position:relative;max-width:1320px;margin:0 auto;">
            <?php iiq_section_marker(); ?>

            <div style="display:grid;grid-template-columns:1fr 1.4fr;gap:80px;align-items:start;">
                <div>
                    <?php iiq_section_eyebrow($eyebrow); ?>
                    <?php if ($headline): ?>
                        <h2 style="margin:18px 0 0;font-family:var(--font-display);font-size:clamp(40px,5.4vw,76px);font-weight:600;letter-spacing:-0.04em;line-height:0.98;color:<?= $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>;">
                            <?= wp_kses_post($headline) ?>
                        </h2>
                    <?php endif; ?>
                </div>
                <?php if (!empty($paragraphs) && is_array($paragraphs)):
                    $last = count($paragraphs) - 1; ?>
                    <div style="display:flex;flex-direction:column;gap:22px;">
                        <?php foreach ($paragraphs as $i => $p):
                            $text = is_array($p) && isset($p['paragraph']) ? $p['paragraph'] : (is_string($p) ? $p : '');
                            if (!$text) continue;
                            $is_first = ($i === 0);
                            $is_last  = ($i === $last);
                        ?>
                            <?php if ($is_last && $last > 0): ?>
                                <div style="margin-top:14px;padding-top:24px;border-top:1px solid <?= $is_dark ? 'oklch(28% 0.005 286)' : 'var(--border-default,#C9C5BD)' ?>;font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:<?= $is_dark ? 'oklch(60% 0.005 286)' : 'var(--fg-tertiary)' ?>;">
                                    <?= wp_kses_post(wp_strip_all_tags($text)) ?>
                                </div>
                            <?php else: ?>
                                <div style="font-size:19px;line-height:<?= $is_first ? '1.6' : '1.65' ?>;color:<?= $is_dark ? ($is_first ? 'var(--ink-50)' : 'oklch(78% 0.005 286)') : ($is_first ? 'var(--fg-primary)' : 'var(--fg-secondary,#5A5A60)') ?>;font-weight:<?= $is_first ? '500' : '400' ?>;margin:0;">
                                    <?= wp_kses_post($text) ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <?php
        // FIDELITY: matches export's WhyItMattersSection (SectionsA.js lines 7-49).
        // Outer maxWidth 1040, padding 40px 0, centered flex. Headline maxWidth 980,
        // two-tone (lead in fg-primary, gap inline span in fg-tertiary). Paragraph
        // marginTop 56, maxWidth 720, fontSize 19, lineHeight 1.65, fg-secondary.
        ?>
        <div style="position:relative;max-width:1040px;margin:0 auto;padding:40px 0;display:flex;flex-direction:column;align-items:center;text-align:center;">
            <?php iiq_section_marker(); ?>

            <?php iiq_section_eyebrow($eyebrow); ?>

            <?php if ($headline_lead && $headline_gap): ?>
                <h2 class="iiq-display-lg" style="margin:18px auto 0;font-family:var(--font-display);font-size:clamp(40px,4.8vw,76px);font-weight:600;letter-spacing:-0.035em;line-height:1.04;max-width:980px;text-wrap:balance;color:<?= $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>;">
                    <?= wp_kses_post($headline_lead) ?><span style="color:var(--fg-tertiary);"> <?= wp_kses_post($headline_gap) ?></span>
                </h2>
            <?php elseif ($headline): ?>
                <h2 class="iiq-display-lg" style="margin:18px auto 0;font-family:var(--font-display);font-size:clamp(40px,4.8vw,76px);font-weight:600;letter-spacing:-0.035em;line-height:1.04;max-width:980px;text-wrap:balance;color:<?= $is_dark ? 'var(--ink-50)' : 'var(--fg-primary)' ?>;">
                    <?= wp_kses_post($headline) ?>
                </h2>
            <?php endif; ?>

            <?php if (!empty($paragraphs) && is_array($paragraphs)): ?>
                <div style="margin:56px auto 0;max-width:720px;display:flex;flex-direction:column;gap:24px;font-size:19px;line-height:1.65;color:<?= $is_dark ? 'oklch(78% 0.005 286)' : 'var(--fg-secondary,#5A5A60)' ?>;text-wrap:pretty;">
                    <?php foreach ($paragraphs as $p):
                        $text = is_array($p) && isset($p['paragraph']) ? $p['paragraph'] : (is_string($p) ? $p : '');
                        if (!$text) continue;
                    ?>
                        <div><?= wp_kses_post($text) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
