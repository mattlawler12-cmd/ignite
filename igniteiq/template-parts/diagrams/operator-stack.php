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
<noscript>
    <div class="iiq-ssr-fallback">
        <span>Operator stack · today</span>
        <span>ServiceTitan</span>
        <span>FieldEdge</span>
        <span>Housecall Pro</span>
        <span>QuickBooks</span>
        <span>Xero</span>
        <span>Salesforce</span>
        <span>HubSpot</span>
        <span>Google Ads</span>
        <span>Meta Ads</span>
        <span>CallRail</span>
        <span>Stripe</span>
        <span>Gusto</span>
        <span>ADP</span>
        <span>Sheets</span>
        <span>Mailchimp</span>
        <span>Podium</span>
        <span>SmartRecruiters</span>
        <span>BambooHR</span>
        <span>Slack</span>
        <span>Zapier</span>
        <span>+5 more</span>
        <span>0</span><span>shared definition of a job</span>
        <span>4</span><span>different IDs for the same customer</span>
        <span>2 wks</span><span>to answer "which channel actually pays"</span>
    </div>
</noscript>
