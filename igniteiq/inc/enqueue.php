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

    // ─────────────────────────────────────────────────────────────────
    // IIQ Design — lifted React diagram components (StackDiagram,
    // PlatformStack, ArchOntologyScene, OperatorStackList, BoundaryDiagram).
    // Mounted via iiq-design-bridge.js into [data-iiq-design] placeholders
    // emitted by template-parts/diagrams/*.php.
    //
    // Order is critical:
    //   1) React + ReactDOM (CDN UMD builds)
    //   2) Reveal.js exposes window.Reveal/Eyebrow/SectionFrame globals
    //   3) Each diagram component (depends on Reveal globals)
    //   4) Bridge mounts components into placeholders (depends on all above)
    // ─────────────────────────────────────────────────────────────────
    $needs_iiq_design = is_front_page()
        || is_page('how-it-works')
        || is_page('ontology')
        || is_page('company');

    if ($needs_iiq_design) {
        $design_js = $js . 'iiq-design/';

        wp_register_script(
            'iiq-react',
            'https://unpkg.com/react@18.3.1/umd/react.production.min.js',
            [],
            '18.3.1',
            true
        );
        wp_register_script(
            'iiq-react-dom',
            'https://unpkg.com/react-dom@18.3.1/umd/react-dom.production.min.js',
            ['iiq-react'],
            '18.3.1',
            true
        );

        wp_register_script(
            'iiq-design-reveal',
            IIQ_URI . '/assets/js/iiq-design/Reveal.js',
            ['iiq-react-dom'],
            filemtime($design_js . 'Reveal.js'),
            true
        );

        wp_register_script(
            'iiq-design-stack',
            IIQ_URI . '/assets/js/iiq-design/StackDiagram.js',
            ['iiq-design-reveal'],
            filemtime($design_js . 'StackDiagram.js'),
            true
        );
        wp_register_script(
            'iiq-design-platform-stack',
            IIQ_URI . '/assets/js/iiq-design/PlatformStack.js',
            ['iiq-design-reveal'],
            filemtime($design_js . 'PlatformStack.js'),
            true
        );
        wp_register_script(
            'iiq-design-arch-ontology',
            IIQ_URI . '/assets/js/iiq-design/ArchOntologyScene.js',
            ['iiq-design-reveal'],
            filemtime($design_js . 'ArchOntologyScene.js'),
            true
        );
        wp_register_script(
            'iiq-design-operator-stack',
            IIQ_URI . '/assets/js/iiq-design/OperatorStackList.js',
            ['iiq-design-reveal'],
            filemtime($design_js . 'OperatorStackList.js'),
            true
        );
        wp_register_script(
            'iiq-design-boundary',
            IIQ_URI . '/assets/js/iiq-design/BoundaryDiagram.js',
            ['iiq-design-reveal'],
            filemtime($design_js . 'BoundaryDiagram.js'),
            true
        );

        wp_register_script(
            'iiq-design-bridge',
            IIQ_URI . '/assets/js/iiq-design-bridge.js',
            [
                'iiq-react',
                'iiq-react-dom',
                'iiq-design-reveal',
                'iiq-design-stack',
                'iiq-design-platform-stack',
                'iiq-design-arch-ontology',
                'iiq-design-operator-stack',
                'iiq-design-boundary',
            ],
            filemtime($js . 'iiq-design-bridge.js'),
            true
        );

        wp_enqueue_script('iiq-design-bridge');
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
