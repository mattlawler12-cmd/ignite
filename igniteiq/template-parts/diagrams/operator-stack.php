<?php
if (!defined('ABSPATH')) exit;
/**
 * Operator Stack — IgniteIQ
 * Static port of the React ProblemSection right-side card.
 * Shows 21 system chips ("Operator stack · today") and 3 callout stats:
 *   0    shared definition of a job
 *   4    different IDs for the same customer
 *   2 wks to answer "which channel actually pays"
 */

$systems = [
    'ServiceTitan', 'FieldEdge', 'Housecall Pro', 'QuickBooks', 'Xero',
    'Salesforce', 'HubSpot', 'Google Ads', 'Meta Ads', 'CallRail',
    'Stripe', 'Gusto', 'ADP', 'Sheets', 'Mailchimp',
    'Podium', 'SmartRecruiters', 'BambooHR', 'Slack', 'Zapier',
    '+5 more',
];

$callouts = [
    ['0',     'shared definition of a job'],
    ['4',     'different IDs for the same customer'],
    ['2 wks', 'to answer "which channel actually pays"'],
];

$last_index = count($systems) - 1;
?>
<div data-iiq-operator-stack style="position:relative;padding:32px 28px;border-radius:10px;border:1px solid var(--border-default,#C9C5BD);background:var(--bg-canvas,#fff);">
    <div style="font-family:var(--font-mono);font-size:10px;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);margin-bottom:16px;">
        Operator stack &middot; today
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:6px;">
        <?php foreach ($systems as $i => $s):
            $is_last = ($i === $last_index);
            $bg      = $is_last ? 'transparent' : '#fff';
            $color   = $is_last ? 'var(--fg-tertiary)' : 'var(--fg-secondary,#5A5A60)';
        ?>
            <span style="font-family:var(--font-sans);font-size:12px;font-weight:500;padding:6px 12px;border-radius:4px;border:1px solid var(--border-subtle,#E2DDD2);background:<?= $bg ?>;color:<?= $color ?>;">
                <?= esc_html($s) ?>
            </span>
        <?php endforeach; ?>
    </div>
    <div style="margin-top:28px;padding-top:22px;border-top:1px dashed var(--border-default,#C9C5BD);">
        <?php foreach ($callouts as $row):
            [$n, $t] = $row;
        ?>
            <div style="display:flex;align-items:baseline;gap:14px;margin-top:8px;">
                <span style="font-family:var(--font-display);font-size:32px;font-weight:700;letter-spacing:-0.025em;color:var(--fg-primary);min-width:80px;">
                    <?= esc_html($n) ?>
                </span>
                <span style="font-size:14px;color:var(--fg-secondary,#5A5A60);">
                    <?= esc_html($t) ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
