<?php
if (!defined('ABSPATH')) exit;

/**
 * Shared rendering helpers for igniteiq section template-parts.
 * Loaded on-demand by each section file via require_once.
 */

if (!function_exists('iiq_section_variant_style')) {
    /**
     * Map a theme_variant key (light|dark|sunken) to inline section CSS.
     * Returns full style="..." attribute (with leading space) or empty string.
     */
    function iiq_section_variant_style($variant) {
        $variant = is_string($variant) ? strtolower(trim($variant)) : '';
        switch ($variant) {
            case 'dark':
                return ' style="background: var(--ink-1000); color: var(--fg-on-inverse, #fff);"';
            case 'sunken':
                return ' style="background: var(--bg-sunken);"';
            case 'light':
                return ' style="background: var(--bg-canvas);"';
            default:
                return '';
        }
    }
}

if (!function_exists('iiq_section_marker')) {
    /**
     * Echo the SectionFrame-style top-left index/label marker.
     * Pulls from the _settings sub-field group when present.
     *
     * Matches the latest JSX SectionFrame helper (Reveal.jsx): two simple spans
     * separated by a 16px gap, no leading bullet, no right-aligned column.
     */
    function iiq_section_marker() {
        $settings = function_exists('get_sub_field') ? get_sub_field('_settings') : null;
        $index = is_array($settings) && !empty($settings['section_index']) ? $settings['section_index'] : '';
        $label = is_array($settings) && !empty($settings['section_label']) ? $settings['section_label'] : '';
        if (!$index && !$label) return;
        ?>
        <div style="position:absolute;top:-120px;left:0;padding:20px 0;display:flex;align-items:center;gap:16px;font-family:'Aeonik Fono',monospace;font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--ignite-500);">
            <?php if ($index): ?><span><?= esc_html($index) ?></span><?php endif; ?>
            <?php if ($label): ?><span style="color:var(--fg-tertiary);"><?= esc_html($label) ?></span><?php endif; ?>
        </div>
        <?php
    }
}

if (!function_exists('iiq_section_eyebrow')) {
    function iiq_section_eyebrow($eyebrow) {
        if (!$eyebrow) return;
        ?>
        <span style="font-family:'Aeonik Fono',monospace;font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:var(--ignite-500);display:inline-flex;align-items:center;gap:8px;">
            <span style="width:6px;height:6px;border-radius:50%;background:var(--ignite-500);animation:iiqPulse 2s ease-in-out infinite;"></span>
            <?= esc_html($eyebrow) ?>
        </span>
        <?php
    }
}

if (!function_exists('iiq_section_variant')) {
    /** Returns the variant string from _settings.theme_variant or ''. */
    function iiq_section_variant() {
        $settings = function_exists('get_sub_field') ? get_sub_field('_settings') : null;
        return is_array($settings) && !empty($settings['theme_variant']) ? $settings['theme_variant'] : '';
    }
}
