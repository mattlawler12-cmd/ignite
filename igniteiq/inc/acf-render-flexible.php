<?php
/**
 * Flexible Content render dispatcher.
 *
 * Loops over ACF flexible-content rows on `page_sections` and includes
 * the corresponding template-part. Heroes route to /heroes/, everything
 * else to /sections/.
 */
if (!defined('ABSPATH')) exit;

if (!function_exists('iiq_render_flexible')) {

function iiq_render_flexible($field_name = 'page_sections') {
    if (!function_exists('have_rows')) return; // ACF not active

    if (!have_rows($field_name)) return;

    while (have_rows($field_name)) {
        the_row();
        $layout = get_row_layout();
        if (!$layout) continue;

        // Convert acf layout slug to file slug: hero_statement -> heroes/statement
        if (strpos($layout, 'hero_') === 0) {
            $variant = substr($layout, 5);
            $part = 'template-parts/heroes/' . sanitize_key($variant);
        } else {
            // section_pillars -> sections/pillars   ; trust_quote -> sections/trust-quote
            $name = preg_replace('/^section_/', '', $layout);
            $name = str_replace('_', '-', $name);
            $part = 'template-parts/sections/' . sanitize_key($name);
        }

        $located = locate_template($part . '.php');
        if ($located) {
            include $located;
        } else {
            echo '<!-- iiq: missing template-part for layout "' . esc_html($layout) . '" (' . esc_html($part) . '.php) -->';
        }
    }
}

}
