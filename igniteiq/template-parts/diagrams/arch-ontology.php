<?php if (!defined('ABSPATH')) exit; ?>
<div data-iiq-arch-scene style="position:relative;border-radius:14px;border:1px solid var(--border-default);background:var(--bg-sunken);overflow:hidden;box-shadow:0 30px 60px -30px oklch(7.5% 0.003 286 / 0.18);">

  <!-- Top header strip -->
  <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 22px;border-bottom:1px solid var(--border-subtle);background:var(--bg-canvas, #fff);font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);">
    <span>YOUR DATA WAREHOUSE</span>
    <span style="display:inline-flex;align-items:center;gap:8px;color:var(--ignite-500);">&#9679; V4.2</span>
  </div>

  <div style="position:relative;width:100%;aspect-ratio:1200 / 600;">
    <svg viewBox="0 0 1200 600" xmlns="http://www.w3.org/2000/svg" style="position:absolute;inset:0;width:100%;height:100%;display:block;" aria-label="IgniteIQ ontology scene">

      <!-- PILLS + CONNECTORS -->

      <!-- JOB pill (row 0) -->
      <g class="iiq-arch-pill" data-iiq-pill="job" style="cursor:default;" tabindex="0">
        <rect class="pill-bg" x="90" y="30" width="106" height="32" rx="3" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <text x="143" y="51" text-anchor="middle" font-family="var(--font-mono)" font-size="11" letter-spacing="2" fill="var(--fg-primary)">JOB</text>
      </g>
      <path class="iiq-arch-connector" data-iiq-connector="job" d="M143,62 L143,194.3 L320,194.3 L320,440" fill="none" stroke="var(--fg-secondary)" stroke-width="1" stroke-linecap="square" />

      <!-- CUSTOMER pill (row 1) -->
      <g class="iiq-arch-pill" data-iiq-pill="customer" style="cursor:default;" tabindex="0">
        <rect class="pill-bg" x="215" y="78" width="106" height="32" rx="3" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <text x="268" y="99" text-anchor="middle" font-family="var(--font-mono)" font-size="11" letter-spacing="2" fill="var(--fg-primary)">CUSTOMER</text>
      </g>
      <path class="iiq-arch-connector" data-iiq-connector="customer" d="M268,110 L268,243 L230,243 L230,490" fill="none" stroke="var(--fg-secondary)" stroke-width="1" stroke-linecap="square" />

      <!-- TECHNICIAN pill (row 0) -->
      <g class="iiq-arch-pill" data-iiq-pill="tech" style="cursor:default;" tabindex="0">
        <rect class="pill-bg" x="340" y="30" width="106" height="32" rx="3" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <text x="393" y="51" text-anchor="middle" font-family="var(--font-mono)" font-size="11" letter-spacing="2" fill="var(--fg-primary)">TECHNICIAN</text>
      </g>
      <path class="iiq-arch-connector" data-iiq-connector="tech" d="M393,62 L393,183.8 L440,183.8 L440,410" fill="none" stroke="var(--fg-secondary)" stroke-width="1" stroke-linecap="square" />

      <!-- TRUCK pill (row 1) -->
      <g class="iiq-arch-pill" data-iiq-pill="truck" style="cursor:default;" tabindex="0">
        <rect class="pill-bg" x="480" y="78" width="106" height="32" rx="3" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <text x="533" y="99" text-anchor="middle" font-family="var(--font-mono)" font-size="11" letter-spacing="2" fill="var(--fg-primary)">TRUCK</text>
      </g>
      <path class="iiq-arch-connector" data-iiq-connector="truck" d="M533,110 L533,204.5 L600,204.5 L600,380" fill="none" stroke="var(--fg-secondary)" stroke-width="1" stroke-linecap="square" />

      <!-- INVOICE pill (row 0) -->
      <g class="iiq-arch-pill" data-iiq-pill="invoice" style="cursor:default;" tabindex="0">
        <rect class="pill-bg" x="605" y="30" width="106" height="32" rx="3" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <text x="658" y="51" text-anchor="middle" font-family="var(--font-mono)" font-size="11" letter-spacing="2" fill="var(--fg-primary)">INVOICE</text>
      </g>
      <path class="iiq-arch-connector" data-iiq-connector="invoice" d="M658,62 L658,183.8 L740,183.8 L740,410" fill="none" stroke="var(--fg-secondary)" stroke-width="1" stroke-linecap="square" />

      <!-- CALL pill (row 1) -->
      <g class="iiq-arch-pill" data-iiq-pill="call" style="cursor:default;" tabindex="0">
        <rect class="pill-bg" x="745" y="78" width="106" height="32" rx="3" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <text x="798" y="99" text-anchor="middle" font-family="var(--font-mono)" font-size="11" letter-spacing="2" fill="var(--fg-primary)">CALL</text>
      </g>
      <path class="iiq-arch-connector" data-iiq-connector="call" d="M798,110 L798,215 L870,215 L870,410" fill="none" stroke="var(--fg-secondary)" stroke-width="1" stroke-linecap="square" />

      <!-- PROPERTY pill (row 0) -->
      <g class="iiq-arch-pill" data-iiq-pill="property" style="cursor:default;" tabindex="0">
        <rect class="pill-bg" x="870" y="30" width="106" height="32" rx="3" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <text x="923" y="51" text-anchor="middle" font-family="var(--font-mono)" font-size="11" letter-spacing="2" fill="var(--fg-primary)">PROPERTY</text>
      </g>
      <path class="iiq-arch-connector" data-iiq-connector="property" d="M923,62 L923,201.3 L970,201.3 L970,460" fill="none" stroke="var(--fg-secondary)" stroke-width="1" stroke-linecap="square" />

      <!-- MEMBERSHIP pill (row 1) -->
      <g class="iiq-arch-pill" data-iiq-pill="membership" style="cursor:default;" tabindex="0">
        <rect class="pill-bg" x="1000" y="78" width="106" height="32" rx="3" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <text x="1053" y="99" text-anchor="middle" font-family="var(--font-mono)" font-size="11" letter-spacing="2" fill="var(--fg-primary)">MEMBERSHIP</text>
      </g>
      <path class="iiq-arch-connector" data-iiq-connector="membership" d="M1053,110 L1053,250 L860,250 L860,510" fill="none" stroke="var(--fg-secondary)" stroke-width="1" stroke-linecap="square" />

      <!-- Pill target dots -->
      <g class="iiq-arch-target" data-iiq-target="job"><circle class="iso-accent" cx="320" cy="440" r="3" fill="var(--fg-primary)" /></g>
      <g class="iiq-arch-target" data-iiq-target="customer"><circle class="iso-accent" cx="230" cy="490" r="3" fill="var(--fg-primary)" /></g>
      <g class="iiq-arch-target" data-iiq-target="tech"><circle class="iso-accent" cx="440" cy="410" r="3" fill="var(--fg-primary)" /></g>
      <g class="iiq-arch-target" data-iiq-target="truck"><circle class="iso-accent" cx="600" cy="380" r="3" fill="var(--fg-primary)" /></g>
      <g class="iiq-arch-target" data-iiq-target="invoice"><circle class="iso-accent" cx="740" cy="410" r="3" fill="var(--fg-primary)" /></g>
      <g class="iiq-arch-target" data-iiq-target="call"><circle class="iso-accent" cx="870" cy="410" r="3" fill="var(--fg-primary)" /></g>
      <g class="iiq-arch-target" data-iiq-target="property"><circle class="iso-accent" cx="970" cy="460" r="3" fill="var(--fg-primary)" /></g>
      <g class="iiq-arch-target" data-iiq-target="membership"><circle class="iso-accent" cx="860" cy="510" r="3" fill="var(--fg-primary)" /></g>

      <!-- GROUND PLATFORM (top half only) -->
      <g>
        <path d="M140,500 L600,380 L1060,500" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <g stroke="var(--border-default)" stroke-width="0.6" opacity="0.6">
          <line x1="216.67" y1="480" x2="676.67" y2="400" />
        </g>
        <g stroke="var(--border-default)" stroke-width="0.6" opacity="0.6">
          <line x1="293.33" y1="460" x2="753.33" y2="420" />
        </g>
        <g stroke="var(--border-default)" stroke-width="0.6" opacity="0.6">
          <line x1="370" y1="440" x2="830" y2="440" />
        </g>
        <g stroke="var(--border-default)" stroke-width="0.6" opacity="0.6">
          <line x1="446.67" y1="420" x2="906.67" y2="460" />
        </g>
        <g stroke="var(--border-default)" stroke-width="0.6" opacity="0.6">
          <line x1="523.33" y1="400" x2="983.33" y2="480" />
        </g>
      </g>

      <!-- Central HQ Building -->
      <g>
        <path d="M530,440 L530,370 L505,356.25 L505,426.25 Z" fill="var(--bg-sunken)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <path d="M670,440 L670,370 L695,356.25 L695,426.25 Z" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <path d="M530,440 L670,440 L670,370 L530,370 Z" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <g stroke="var(--fg-primary)" stroke-width="1.25" fill="var(--bg-canvas, #fff)">
          <rect x="582" y="344" width="9" height="26" />
          <rect x="608" y="334" width="9" height="36" />
        </g>
        <g stroke="var(--fg-primary)" stroke-width="0.8" fill="none">
          <g>
            <rect x="544" y="386" width="26" height="12" />
            <rect x="544" y="414" width="26" height="12" />
          </g>
          <g>
            <rect x="586" y="386" width="26" height="12" />
            <rect x="586" y="414" width="26" height="12" />
          </g>
          <g>
            <rect x="628" y="386" width="26" height="12" />
            <rect x="628" y="414" width="26" height="12" />
          </g>
        </g>
      </g>

      <!-- IsoJobSite (320, 440) -->
      <g transform="translate(320 440)" stroke="var(--fg-primary)" stroke-width="1.25" fill="var(--bg-canvas, #fff)">
        <path d="M-28,8 L0,-6 L28,8 L0,22 Z" fill="var(--bg-sunken)" />
        <path d="M0,-30 C-9,-30 -14,-22 -14,-16 C-14,-8 0,4 0,4 C0,4 14,-8 14,-16 C14,-22 9,-30 0,-30 Z" />
        <circle cx="0" cy="-17" r="4" fill="var(--bg-sunken)" />
      </g>

      <!-- IsoHouse customer (230, 490) -->
      <g>
        <path d="M195,490 L265,490 L265,446 L195,446 Z" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <path d="M265,490 L284,479.36 L284,435.36 L265,446 Z" fill="var(--bg-sunken)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <path d="M195,446 L265,446 L284,435.36 L239.5,422.68 L220.5,428 Z" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <rect x="223" y="465.8" width="14" height="24.2" fill="var(--bg-sunken)" stroke="var(--fg-primary)" stroke-width="0.8" />
        <rect x="203.4" y="454.8" width="14" height="12.32" fill="none" stroke="var(--fg-primary)" stroke-width="0.8" />
      </g>

      <!-- IsoTech (440, 410) -->
      <g transform="translate(440 410)" stroke="var(--fg-primary)" stroke-width="1.25" fill="var(--bg-canvas, #fff)">
        <ellipse cx="0" cy="22" rx="10" ry="3" fill="var(--border-subtle)" stroke="none" opacity="0.7" />
        <circle cx="0" cy="-12" r="5" />
        <path d="M-5,-8 L-7,8 L7,8 L5,-8 Z" />
        <line x1="-5" y1="8" x2="-6" y2="22" />
        <line x1="5" y1="8" x2="6" y2="22" />
        <line x1="-5" y1="-14" x2="5" y2="-14" />
      </g>

      <!-- IsoTruck (600, 380) -->
      <g transform="translate(600 380)">
        <ellipse cx="0" cy="14" rx="38" ry="5" fill="var(--border-subtle)" opacity="0.6" />
        <path d="M-32,2 L8,2 L8,-28 L-32,-28 Z" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <path d="M8,2 L20,-4 L20,-34 L-32,-34 L-32,-28 L8,-28 Z" fill="var(--bg-sunken)" stroke="var(--fg-primary)" stroke-width="1.25" opacity="0.95" />
        <path d="M8,2 L26,2 L26,-14 L20,-14 L20,-4 L8,-4 Z" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <circle cx="-22" cy="4" r="5" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <circle cx="-2" cy="4" r="5" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <circle cx="20" cy="4" r="5" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <line x1="-28" y1="-12" x2="4" y2="-12" stroke="var(--fg-primary)" stroke-width="0.8" />
      </g>

      <!-- IsoInvoice (740, 410) -->
      <g transform="translate(740 410)" stroke="var(--fg-primary)" stroke-width="1.25" fill="var(--bg-canvas, #fff)">
        <path d="M-22,4 L18,4 L26,-2 L-14,-2 Z" fill="var(--bg-sunken)" />
        <path d="M-20,-2 L20,-2 L28,-8 L-12,-8 Z" />
        <path d="M-18,-8 L22,-8 L30,-14 L-10,-14 Z" />
        <line x1="-12" y1="-12" x2="22" y2="-12" stroke="var(--fg-primary)" stroke-width="0.8" />
        <line x1="-10" y1="-10" x2="20" y2="-10" stroke="var(--fg-primary)" stroke-width="0.8" />
      </g>

      <!-- IsoCallTower (870, 410) -->
      <g transform="translate(870 410)" stroke="var(--fg-primary)" stroke-width="1.25" fill="none">
        <path d="M-10,16 L-3,-30 L3,-30 L10,16 Z" fill="var(--bg-canvas, #fff)" />
        <line x1="-8" y1="0" x2="8" y2="0" />
        <line x1="-6" y1="-12" x2="6" y2="-12" />
        <line x1="-4" y1="-22" x2="4" y2="-22" />
        <path d="M-18,-28 Q0,-44 18,-28" />
        <path d="M-12,-26 Q0,-36 12,-26" />
      </g>

      <!-- IsoHouse property (970, 460) small -->
      <g>
        <path d="M945,460 L995,460 L995,428 L945,428 Z" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <path d="M995,460 L1009,452.16 L1009,420.16 L995,428 Z" fill="var(--bg-sunken)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <path d="M945,428 L995,428 L1009,420.16 L977,406.08 L963,410 Z" fill="var(--bg-canvas, #fff)" stroke="var(--fg-primary)" stroke-width="1.25" />
        <rect x="965" y="442.4" width="10" height="17.6" fill="var(--bg-sunken)" stroke="var(--fg-primary)" stroke-width="0.8" />
      </g>

      <!-- IsoMembership (860, 510) -->
      <g transform="translate(860 510)" stroke="var(--fg-primary)" stroke-width="1.25" fill="var(--bg-canvas, #fff)">
        <path d="M-22,-2 L14,-14 L26,-8 L-10,4 Z" fill="var(--bg-sunken)" />
        <line x1="-16" y1="-1" x2="-2" y2="-6" stroke="var(--fg-primary)" stroke-width="0.8" />
        <line x1="-14" y1="2" x2="6" y2="-6" stroke="var(--fg-primary)" stroke-width="0.8" />
      </g>

      <!-- Background atmosphere -->
      <!-- IsoSilo (150, 490) -->
      <g transform="translate(150 490)" stroke="var(--border-default)" stroke-width="1" fill="var(--bg-canvas, #fff)">
        <ellipse cx="0" cy="-30" rx="9" ry="3" />
        <path d="M-9,-30 L-9,8 L9,8 L9,-30" />
        <ellipse cx="0" cy="8" rx="9" ry="3" fill="var(--bg-sunken)" />
      </g>

      <!-- IsoTree (1080, 520) -->
      <g transform="translate(1080 520)" stroke="var(--border-default)" stroke-width="1" fill="var(--bg-canvas, #fff)">
        <path d="M0,-30 L-10,-6 L10,-6 Z" />
        <path d="M0,-18 L-12,8 L12,8 Z" />
        <line x1="0" y1="8" x2="0" y2="14" />
      </g>

      <!-- "prod" tag -->
      <g transform="translate(1000 560)">
        <rect x="-30" y="-12" width="60" height="22" rx="2" fill="var(--fg-primary)" />
        <text x="0" y="3" text-anchor="middle" font-family="var(--font-mono)" font-size="10" letter-spacing="1.5" fill="var(--bg-canvas, #fff)">prod</text>
      </g>
    </svg>

    <!-- Inspector callout -->
    <div style="position:absolute;left:16px;top:130px;width:210px;background:var(--bg-canvas, #fff);border:1px solid var(--fg-primary);border-radius:4px;font-family:var(--font-mono);font-size:10px;color:var(--fg-primary);box-shadow:0 12px 28px -10px oklch(7.5% 0.003 286 / 0.18);z-index:2;">
      <div style="padding:8px 12px;border-bottom:1px solid var(--border-default);letter-spacing:0.16em;text-transform:uppercase;font-size:10px;">JOB OBJECT</div>
      <div style="padding:10px 12px;display:grid;grid-template-columns:1fr auto;row-gap:6px;column-gap:12px;">
        <span style="color:var(--fg-tertiary);">Status</span>
        <span><span style="color:var(--ignite-500);">&#9679; </span>Dispatched</span>
        <span style="color:var(--fg-tertiary);">Value</span>
        <span>$1,840</span>
        <span style="color:var(--fg-tertiary);">Technician</span>
        <span>R. Alvarez</span>
        <span style="color:var(--fg-tertiary);">ETA</span>
        <span>14:22</span>
        <span style="color:var(--fg-tertiary);">Margin</span>
        <span>38.4%</span>
        <span style="color:var(--fg-tertiary);">Callback risk</span>
        <span>Low <span style="color:var(--ignite-500);">&#8600;</span></span>
      </div>
    </div>
  </div>

  <!-- Bottom legend strip -->
  <div style="padding:20px 32px;border-top:1px solid var(--border-default);background:var(--bg-canvas, #fff);display:flex;justify-content:center;align-items:center;gap:18px;flex-wrap:wrap;">
    <span style="font-family:var(--font-mono);font-size:10px;letter-spacing:0.18em;text-transform:uppercase;color:var(--ignite-500);">&#9679; Built on your cloud</span>
    <span style="font-size:13px;color:var(--fg-secondary);">Every line of business &mdash; every job, customer, technician, truck &mdash; resolved into one model that lives in your warehouse and is queried by the framework.</span>
  </div>
</div>

<style>
[data-iiq-arch-scene] .iiq-arch-pill rect.pill-bg.iiq-arch-active,
[data-iiq-arch-scene] .iiq-arch-pill.iiq-arch-active rect { stroke: var(--ignite-500) !important; }
[data-iiq-arch-scene] .iiq-arch-connector.iiq-arch-active { stroke: var(--ignite-500) !important; }
[data-iiq-arch-scene] .iiq-arch-target.iiq-arch-active circle.iso-accent { fill: var(--ignite-500) !important; }
[data-iiq-arch-scene] .iiq-arch-pill.iiq-arch-active text { fill: var(--ignite-500) !important; }
</style>
