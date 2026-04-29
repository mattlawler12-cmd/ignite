<?php
if (!defined('ABSPATH')) exit;

/**
 * Architecture Ontology Scene — IgniteIQ
 * Placeholder mount-point for the lifted React `ArchOntologyScene` component
 * (assets/js/iiq-design/ArchOntologyScene.js → window.ArchOntologyScene).
 *
 * The component renders the full ontology data-warehouse scene (top header
 * strip, pill grid, ontology pills with connectors, source-systems strip)
 * inside a self-contained card. No props are accepted (matches the export's
 * React signature: `function ArchOntologyScene() { ... }`).
 *
 * Dropped inside template-parts/sections/split.php's right-column slot — the
 * surrounding section + headline are provided by that split host.
 */
?>
<div data-iiq-design="arch-ontology"></div>
