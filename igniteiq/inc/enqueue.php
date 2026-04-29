<?php
if (!defined('ABSPATH')) exit;

add_action('wp_enqueue_scripts', function () {
    $css = IIQ_DIR . '/assets/css/';
    $js  = IIQ_DIR . '/assets/js/';

    // Order is critical: tokens defines CSS vars and @font-face; responsive depends on it.
    wp_enqueue_style('iiq-tokens', IIQ_URI . '/assets/css/tokens.css', [], filemtime($css . 'tokens.css'));
    wp_enqueue_style('iiq-responsive', IIQ_URI . '/assets/css/responsive.css', ['iiq-tokens'], filemtime($css . 'responsive.css'));
    wp_enqueue_style('iiq-theme', IIQ_URI . '/assets/css/theme.css', ['iiq-tokens', 'iiq-responsive'], filemtime($css . 'theme.css'));

    wp_enqueue_script('iiq-nav', IIQ_URI . '/assets/js/nav.js', [], filemtime($js . 'nav.js'), true);
    wp_enqueue_script('iiq-reveal', IIQ_URI . '/assets/js/reveal.js', [], filemtime($js . 'reveal.js'), true);
    if (file_exists($js . 'parallax.js')) {
        wp_enqueue_script('iiq-parallax', IIQ_URI . '/assets/js/parallax.js', [], filemtime($js . 'parallax.js'), true);
    }

    if (file_exists($js . 'lattice.js')) {
        wp_enqueue_script('iiq-lattice', IIQ_URI . '/assets/js/lattice.js', [], filemtime($js . 'lattice.js'), true);
    }
    if (file_exists($js . 'arch-ontology.js')) {
        wp_enqueue_script('iiq-arch-ontology', IIQ_URI . '/assets/js/arch-ontology.js', [], filemtime($js . 'arch-ontology.js'), true);
    }

    if (is_page('contact') || is_front_page()) {
        wp_enqueue_script('iiq-contact-form', IIQ_URI . '/assets/js/contact-form.js', [], filemtime($js . 'contact-form.js'), true);
        wp_localize_script('iiq-contact-form', 'IIQ_CONTACT', [
            'ajax'  => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('iiq_contact'),
        ]);
    }
});

/**
 * Preload Aeonik regular + bold for faster first-paint headlines.
 */
add_action('wp_head', function () {
    $regular = IIQ_URI . '/assets/fonts/Aeonik-Regular.otf';
    $bold    = IIQ_URI . '/assets/fonts/Aeonik-Bold.otf';
    echo '<link rel="preload" href="' . esc_url($regular) . '" as="font" type="font/otf" crossorigin>' . "\n";
    echo '<link rel="preload" href="' . esc_url($bold) . '" as="font" type="font/otf" crossorigin>' . "\n";
}, 1);
