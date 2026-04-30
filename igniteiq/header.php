<?php
if (!defined('ABSPATH')) exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
// Detect cinematic hero on the current page so the nav can render in inverse mode.
$iiq_use_inverse_nav = false;
if (function_exists('have_rows') && (is_singular() || is_front_page())) {
    $iiq_pid = is_front_page() ? (int) get_option('page_on_front') : (get_queried_object_id() ?: 0);
    if ($iiq_pid && have_rows('page_sections', $iiq_pid)) {
        while (have_rows('page_sections', $iiq_pid)) {
            the_row();
            $iiq_layout = get_row_layout();
            if ($iiq_layout === 'hero_cinematic') {
                $iiq_use_inverse_nav = true;
            } elseif ($iiq_layout === 'hero_editorial' && get_sub_field('dark')) {
                // Dark editorial hero (e.g. how-it-works ArchHero) — nav must
                // render light-on-dark to stay legible.
                $iiq_use_inverse_nav = true;
            }
            // Only the first row matters (hero is always first); break after one row.
            break;
        }
        // Reset flexible content cursor for the actual render later.
        if (function_exists('reset_rows')) reset_rows();
    }
}
set_query_var('iiq_nav_inverse', $iiq_use_inverse_nav);
get_template_part('template-parts/nav');
?>

<main id="iiq-main" role="main">
