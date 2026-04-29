<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$form_type = get_sub_field('form_type') ?: 'contact';
$variant   = iiq_section_variant();
$slug      = sanitize_key($form_type);

// FIDELITY: forms/contact.php renders its OWN <section> with padding
// 120/32/160 (matches Contact.js:61). Wrapping it here in another
// iiq-section-pad section produces ~80-120px of extra bottom whitespace
// before the footer. For contact, render the inner template-part
// directly with no outer wrapper.
if ($slug === 'contact') {
    if (locate_template('template-parts/forms/contact.php')) {
        get_template_part('template-parts/forms/contact');
    }
    return;
}
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
