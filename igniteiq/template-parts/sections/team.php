<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$headline     = get_sub_field('headline') ?: '';
$members      = get_sub_field('members') ?: [];
$avatar_style = get_sub_field('avatar_style') ?: 'circle';
$variant      = iiq_section_variant();
$is_square    = ($avatar_style === 'square');

if (!function_exists('iiq_team_initials')) {
    function iiq_team_initials($name) {
        $name = trim((string) $name);
        if (!$name) return '';
        $parts = preg_split('/\s+/', $name);
        $i = '';
        foreach ($parts as $p) {
            if ($p !== '') $i .= mb_substr($p, 0, 1);
            if (mb_strlen($i) >= 2) break;
        }
        return strtoupper($i);
    }
}

$avatar_size  = $is_square ? 64 : 72;
$avatar_radius = $is_square ? '6px' : '50%';
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:1320px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <?php if ($headline): ?>
            <h2 class="iiq-display-lg" style="margin:0 0 56px;max-width:880px;font-family:var(--font-display);font-weight:600;letter-spacing:-0.025em;line-height:1.05;">
                <?= wp_kses_post($headline) ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($members) && is_array($members)): ?>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
                <?php foreach ($members as $m):
                    $name  = isset($m['name']) ? $m['name'] : '';
                    $role  = isset($m['role']) ? $m['role'] : '';
                    $bio   = isset($m['bio']) ? $m['bio'] : '';
                    $photo = isset($m['photo']) ? $m['photo'] : null;
                    $has_photo = is_array($photo) && !empty($photo['ID']);
                ?>
                    <article style="background:var(--bg-canvas,#fff);border:1px solid var(--border-default,#C9C5BD);<?= $is_square ? '' : 'border-radius:14px;' ?>padding:32px 28px;display:flex;flex-direction:column;gap:20px;height:100%;">
                        <?php if ($has_photo): ?>
                            <div style="width:<?= $avatar_size ?>px;height:<?= $avatar_size ?>px;border-radius:<?= $avatar_radius ?>;overflow:hidden;background:var(--bg-sunken,#F4EFE4);flex-shrink:0;">
                                <?= wp_get_attachment_image(
                                    (int) $photo['ID'],
                                    [$avatar_size * 2, $avatar_size * 2],
                                    false,
                                    ['style' => 'width:100%;height:100%;object-fit:cover;display:block;', 'alt' => esc_attr($name)]
                                ) ?>
                            </div>
                        <?php elseif ($is_square): ?>
                            <div aria-hidden="true" style="position:relative;width:64px;height:64px;border-radius:6px;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#1F1F23,#3F3F46);">
                                <div style="position:absolute;inset:0;background:radial-gradient(circle at 30% 30%,oklch(57.5% 0.232 25 / 0.4),transparent 60%);"></div>
                                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:22px;font-weight:600;color:var(--ink-50,#FAFAFA);letter-spacing:-0.02em;">
                                    <?= esc_html(iiq_team_initials($name)) ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div aria-hidden="true" style="width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--ignite-500),#7A1018);color:#fff;font-family:'Aeonik Fono',monospace;font-size:22px;font-weight:600;letter-spacing:0.04em;flex-shrink:0;">
                                <?= esc_html(iiq_team_initials($name)) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($name): ?>
                            <h3 style="margin:0;font-family:var(--font-display);font-size:24px;line-height:1.15;font-weight:600;letter-spacing:-0.025em;color:var(--fg-primary);">
                                <?= esc_html($name) ?>
                            </h3>
                        <?php endif; ?>
                        <?php if ($role): ?>
                            <div style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:var(--ignite-500);margin-top:-14px;">
                                <?= esc_html($role) ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($bio): ?>
                            <div style="font-size:15px;line-height:1.6;color:var(--fg-secondary,#5A5A60);">
                                <?= wp_kses_post($bio) ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
