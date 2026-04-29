<?php
/** Default template fallback. */
if (!defined('ABSPATH')) exit;
get_header();
echo '<section class="iiq-pad iiq-section-pad" style="max-width:880px;margin:0 auto;padding-top:160px;">';
if (have_posts()) {
    while (have_posts()) { the_post();
        echo '<article style="margin-bottom:48px;">';
        echo '<h1 class="iiq-display-md">' . esc_html(get_the_title()) . '</h1>';
        the_content();
        echo '</article>';
    }
} else {
    echo '<h1>Nothing here.</h1>';
}
echo '</section>';
get_footer();
