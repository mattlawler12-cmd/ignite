<?php
if (!defined('ABSPATH')) exit;

add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary' => __('Primary', 'igniteiq'),
    ]);
});
