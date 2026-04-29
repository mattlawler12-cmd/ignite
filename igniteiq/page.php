<?php
/** Generic page fallback (used for any page without a more specific template). */
if (!defined('ABSPATH')) exit;
get_header();
if (have_posts()) { while (have_posts()) { the_post();
    if (function_exists('iiq_render_flexible') && function_exists('have_rows') && have_rows('page_sections')) {
        iiq_render_flexible();
    } else {
        echo '<article class="iiq-pad iiq-section-pad" style="max-width:880px;margin:0 auto;">';
        echo '<h1 class="iiq-display-lg">' . esc_html(get_the_title()) . '</h1>';
        the_content();
        echo '</article>';
    }
} }
get_footer();
