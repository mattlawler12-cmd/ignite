<?php
if (!defined('ABSPATH')) exit;

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
});

/**
 * Disable the editor for pages where flexible content is the source of truth.
 * Editors fill content via the ACF "Page Sections" field group, not the_content().
 */
add_filter('use_block_editor_for_post', function ($use, $post) {
    if (!$post || $post->post_type !== 'page') return $use;
    $iiq_pages = ['front-page', 'how-it-works', 'ontology', 'company', 'contact', 'signin'];
    if (in_array($post->post_name, $iiq_pages, true)) return false;
    return $use;
}, 10, 2);
