<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$form_type = get_sub_field('form_type') ?: 'contact';
$variant   = iiq_section_variant();
$slug      = sanitize_key($form_type);
?>
<section data-reveal class="iiq-pad iiq-section-pad"<?= iiq_section_variant_style($variant) ?>>
    <div style="position:relative;max-width:760px;margin:0 auto;">
        <?php iiq_section_marker(); ?>

        <?php
        if ($slug && locate_template('template-parts/forms/' . $slug . '.php')) {
            get_template_part('template-parts/forms/' . $slug);
        }
        ?>
    </div>
</section>
