<?php
if (!defined('ABSPATH')) exit;

/**
 * Platform Stack Diagram — IgniteIQ
 * Placeholder mount-point for the lifted React `PlatformStackDiagram`
 * component (assets/js/iiq-design/PlatformStack.js → window.PlatformStackDiagram).
 *
 * The component renders its own outer <section> with the "The most intelligent
 * infrastructure in home services" headline, the DATA / LOGIC / ACTIONS
 * pill chips, and the three-plane isometric stack — all internally hardcoded.
 * No props are accepted (matches the export's React signature: `function
 * PlatformStackDiagram() { ... }`).
 */
?>
<div data-iiq-design="platform-stack"></div>
<noscript>
    <div class="iiq-ssr-fallback">
        <h2>The most intelligent infrastructure in home services</h2>
        <span>DATA</span><span>[Information]</span>
        <p>Your cloud warehouse — Snowflake, BigQuery, or Databricks. 25+ operational systems sync in: ServiceTitan, FieldEdge, accounting, marketing, telephony. Raw, staged, marted. Always under your IAM, never copied out.</p>
        <span>LOGIC</span><span>[Intelligence]</span>
        <p>The ontology — twelve resolved entities (job, technician, lead, invoice, customer, equipment) that compose every business question. The shared object model that lets agents and operators speak the same language as the data.</p>
        <span>ACTIONS</span><span>[Outcomes]</span>
        <p>Chat, signals, agents, decisions. The surface where operators ask, are told, and act. Every action is grounded in the ontology and writes back through the systems your team already uses.</p>
    </div>
</noscript>
