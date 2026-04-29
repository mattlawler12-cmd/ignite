<?php
/**
 * Front Page (Home)
 * Renders ACF Flexible Content `page_sections` for the page set as the static front page.
 */
if (!defined('ABSPATH')) exit;

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        if (function_exists('iiq_render_flexible')) {
            iiq_render_flexible();
        } else {
            the_content();
        }
    }
}

get_footer();
