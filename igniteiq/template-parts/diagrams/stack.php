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
?>
<div data-iiq-design="stack-diagram" data-iiq-props="<?php echo esc_attr(wp_json_encode($props)); ?>"></div>
