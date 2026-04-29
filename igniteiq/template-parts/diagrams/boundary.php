<?php
if (!defined('ABSPATH')) exit;

/**
 * Boundary Diagram — IgniteIQ
 * Placeholder mount-point for the lifted React `BoundaryDiagram` component
 * (assets/js/iiq-design/BoundaryDiagram.js → window.BoundaryDiagram).
 *
 * The component renders the two-column boundary card (Stays in customer cloud
 * / Operational data on left, Compounds in framework / Patterns & intelligence
 * on right) — extracted byte-accurately from Architecture.js
 * ArchCompoundingDiagram (the inner two-column block, sans its outer Block
 * section + outer headline). No props are accepted.
 *
 * Dropped inside template-parts/sections/split.php's right-column slot — the
 * surrounding section + headline are provided by that split host.
 */
?>
<div data-iiq-design="boundary"></div>
