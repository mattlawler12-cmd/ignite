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
        <?php
        // Gap CT4: the contact form template renders its own "Send us a note"
        // eyebrow inside the form panel (template-parts/forms/contact.php),
        // so the wrapping section marker (which prepends a "01" index from
        // _settings.section_index) is suppressed here to match the export,
        // which shows just "SEND US A NOTE" with no numeric prefix.
        if ($slug !== 'contact') {
            iiq_section_marker();
        }
        ?>

        <?php
        if ($slug && locate_template('template-parts/forms/' . $slug . '.php')) {
            get_template_part('template-parts/forms/' . $slug);
        }
        ?>
    </div>
</section>
