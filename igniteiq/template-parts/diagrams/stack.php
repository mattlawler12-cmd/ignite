<?php
if (!defined('ABSPATH')) exit;

/**
 * Stack Diagram — IgniteIQ
 * Placeholder mount-point for the lifted React `ArchStackDiagram` component
 * (assets/js/iiq-design/StackDiagram.js → window.ArchStackDiagram).
 *
 * The component renders its own outer <section> with header-marker, headline,
 * isometric four-platform stack SVG, and closing-line block — driven entirely
 * by the props mapped below from the existing ACF schema.
 */

$props = [];
if ($v = get_sub_field('index'))           $props['index']         = $v;
if ($v = get_sub_field('label'))           $props['label']         = $v;
if ($v = get_sub_field('header_label'))    $props['headerLabel']   = $v;
if ($v = get_sub_field('headline_left'))   $props['headlineLeft']  = $v;
if ($v = get_sub_field('headline_right'))  $props['headlineRight'] = $v;
if ($v = get_sub_field('body'))            $props['body']          = $v;
if ($v = get_sub_field('closing_line'))    $props['closingLine']   = $v;

$ssr_index         = $props['index'] ?? '';
$ssr_label         = $props['label'] ?? 'The stack';
$ssr_header_label  = $props['headerLabel'] ?? 'How it all fits together';
$ssr_headline_left = $props['headlineLeft'] ?? 'One model of your business.';
$ssr_headline_right = $props['headlineRight'] ?? 'Every product, every object, every system reads from it.';
$ssr_body          = $props['body'] ?? '';
$ssr_closing_line  = $props['closingLine'] ?? 'Every decision — faster, smarter, and right.';
?>
<div data-iiq-design="stack-diagram" data-iiq-props="<?php echo esc_attr(wp_json_encode($props)); ?>"></div>
<noscript>
    <div class="iiq-ssr-fallback">
        <span><?= esc_html($ssr_index) ?></span>
        <span><?= esc_html($ssr_label) ?></span>
        <span><?= esc_html($ssr_header_label) ?></span>
        <h2><?= esc_html($ssr_headline_left) ?> <?= esc_html($ssr_headline_right) ?></h2>
        <p><?= esc_html($ssr_body) ?></p>
        <span>THE NOUNS, VERBS, AND DATA RELATIONSHIPS OF HOW YOUR BUSINESS ACTUALLY RUNS</span>
        <span>JOB Nº 4827</span>
        <span>FSM · OPS · FINANCE</span>
        <span>MODELS &amp; LOGIC</span>
        <span>SCORING · RESOLUTION · FORECAST</span>
        <span>ANALYTICS &amp; BI</span>
        <span>WORKFLOWS &amp; AUTOMATIONS</span>
        <span>CHAT · UI</span>
        <span>WRITE-BACK · DISPATCH · NOTIFY</span>
        <span>AGENTIC AGENTS &amp; TOOLS</span>
        <span>AGENTIC INTELLIGENCE</span>
        <h3>Every decision — <em>faster, smarter, and right.</em></h3>
        <p><?= esc_html($ssr_closing_line) ?></p>
    </div>
</noscript>
