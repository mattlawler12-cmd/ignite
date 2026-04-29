<?php
if (!defined('ABSPATH')) exit;

/**
 * Operator Stack — IgniteIQ
 * Placeholder mount-point for the lifted React `OperatorStackList` component
 * (assets/js/iiq-design/OperatorStackList.js → window.OperatorStackList).
 *
 * The component renders the "Operator stack · today" badges grid (21 system
 * chips) plus the three dashed-bottom callout stats — extracted byte-accurately
 * from SectionsA.js ProblemSection right-column panel. No props are accepted.
 *
 * Dropped inside template-parts/sections/split.php's right-column slot — the
 * surrounding section + headline are provided by that split host.
 */
?>
<div data-iiq-design="operator-stack"></div>
