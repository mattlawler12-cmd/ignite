<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('get_sub_field')) return;
require_once __DIR__ . '/_helpers.php';

$diagram_key = get_sub_field('diagram_key') ?: '';
$caption     = get_sub_field('caption') ?: '';
$variant     = iiq_section_variant();
?>
<?php
// Diagram dispatcher. The inner diagram template-parts (stack, platform-stack,
// boundary, etc.) each provide their OWN <section> element with background,
// padding, max-width container, and section header. The dispatcher therefore
// just passes through — no outer section wrapper. Wrapping with iiq-pad here
// would cut 32px off each side of the inner diagram and expose the page
// background as visible side margins (the bug the user reported).
//
// The optional `caption` field is rendered inside its own constrained block
// AFTER the diagram so it inherits the diagram's centered context.
?>
<?php
if ($diagram_key) {
    $slug = sanitize_key($diagram_key);
    if (locate_template('template-parts/diagrams/' . $slug . '.php')) {
        get_template_part('template-parts/diagrams/' . $slug);
    }
}
?>

<?php if ($caption): ?>
    <div class="iiq-pad iiq-section-pad" style="padding-top:0;padding-bottom:48px;">
        <p style="max-width:760px;margin:0 auto;text-align:center;font-family:'Aeonik Fono',monospace;font-size:13px;letter-spacing:0.06em;color:var(--fg-secondary,#5A5A60);">
            <?= wp_kses_post($caption) ?>
        </p>
    </div>
<?php endif; ?>
