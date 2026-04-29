<?php
if (!defined('ABSPATH')) exit;

add_action('acf/init', function () {
    if (!function_exists('acf_add_options_page')) return;

    acf_add_options_page([
        'page_title' => 'Site Settings',
        'menu_title' => 'Site Settings',
        'menu_slug'  => 'iiq_site_settings',
        'capability' => 'edit_theme_options',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-settings',
        'position'   => 60,
    ]);
});

/**
 * Helper: read a Site Settings option.
 */
if (!function_exists('iiq_setting')) {
    function iiq_setting($key, $default = '') {
        if (!function_exists('get_field')) return $default;
        $val = get_field($key, 'option');
        return $val !== null && $val !== '' && $val !== false ? $val : $default;
    }
}
