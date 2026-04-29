<?php
if (!defined('ABSPATH')) exit;

/**
 * Contact form — static markup, submitted via /assets/js/contact-form.js
 * to admin-ajax (action=iiq_contact). Spam mitigation: nonce, honeypot, time-trap.
 *
 * Strings are byte-accurate to the latest Claude Design export
 * (exports/latest/js/Contact.js). Office addresses, email, phone, topic
 * options, labels, placeholders, helper text, and button copy must match
 * the export exactly — including curly apostrophes (’), ellipses (…),
 * and the trailing arrow (→) on the submit button.
 *
 * If you change the topic options here, also update IIQ_CONTACT_TOPICS
 * in inc/contact-form.php — the handler validates against that list.
 */

$topics = [
    'I want a demo',
    'I’m evaluating IgniteIQ vs. another platform',
    'Partnership / integration',
    'Press / analyst',
    'Other',
];

$nonce = wp_create_nonce('iiq_contact');
?>
<section data-reveal class="iiq-pad iiq-section-pad" style="padding:120px 32px 160px;background:var(--bg-canvas);border-bottom:1px solid var(--border-default);">
  <div style="max-width:1320px;margin:0 auto;display:grid;grid-template-columns:0.9fr 1.4fr;gap:96px;align-items:flex-start;" class="iiq-grid-split">

    <aside>
      <div style="padding-bottom:24px;border-bottom:1px solid var(--border-default);font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);">Offices</div>

      <div style="padding:28px 0;border-bottom:1px solid var(--border-subtle);">
        <div style="display:flex;align-items:baseline;gap:12px;flex-wrap:wrap;">
          <h3 style="font-family:var(--font-display);font-size:28px;font-weight:600;letter-spacing:-0.025em;margin:0;color:var(--fg-primary);">San Diego</h3>
          <span style="font-family:var(--font-mono);font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:var(--ignite-500);padding:3px 8px;border:1px solid var(--ignite-500);border-radius:3px;">HQ</span>
        </div>
        <div style="margin-top:10px;font-size:15px;line-height:1.6;color:var(--fg-secondary);">
          <div>1234 Kettner Blvd, Suite 500</div>
          <div>San Diego, CA 92101</div>
        </div>
      </div>

      <div style="padding:28px 0;border-bottom:1px solid var(--border-subtle);">
        <div style="display:flex;align-items:baseline;gap:12px;flex-wrap:wrap;">
          <h3 style="font-family:var(--font-display);font-size:28px;font-weight:600;letter-spacing:-0.025em;margin:0;color:var(--fg-primary);">San Francisco</h3>
        </div>
        <div style="margin-top:10px;font-size:15px;line-height:1.6;color:var(--fg-secondary);">
          <div>600 Montgomery St, 12th Floor</div>
          <div>San Francisco, CA 94111</div>
        </div>
      </div>

      <div style="margin-top:56px;padding-top:24px;border-top:1px solid var(--border-default);font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);">Direct</div>
      <div style="margin-top:20px;display:flex;flex-direction:column;gap:10px;">
        <a href="mailto:hello@igniteiq.com" style="font-family:var(--font-display);font-size:22px;font-weight:500;letter-spacing:-0.02em;color:var(--fg-primary);text-decoration:none;">hello@igniteiq.com</a>
        <span style="font-size:15px;color:var(--fg-secondary);">+1 (619) 555-0114</span>
      </div>
    </aside>

    <div style="padding:40px 44px 44px;border:1px solid var(--border-default);background:var(--bg-base);">

      <div data-iiq-contact-success hidden style="padding:40px 0;">
        <div style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--ignite-500);">● Received</div>
        <h2 style="font-family:var(--font-display);font-size:36px;font-weight:600;letter-spacing:-0.03em;line-height:1.1;margin:20px 0 0;color:var(--fg-primary);">Thanks. We&rsquo;ll be in touch.</h2>
        <p style="margin-top:16px;font-size:16px;line-height:1.55;color:var(--fg-secondary);max-width:540px;">Someone on our team will reach out within one business day. In the meantime, feel free to see how it works, or read about the ontology.</p>
      </div>

      <form data-iiq-contact-form method="post" action="<?= esc_url(admin_url('admin-ajax.php')) ?>" novalidate style="display:flex;flex-direction:column;gap:24px;">
        <input type="hidden" name="action" value="iiq_contact">
        <input type="hidden" name="nonce" value="<?= esc_attr($nonce) ?>">
        <input type="hidden" name="rendered_at" value="0">

        <div class="iiq-honeypot" aria-hidden="true">
          <label>Website (leave blank)<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        </div>

        <div style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);padding-bottom:16px;border-bottom:1px solid var(--border-default);margin-bottom:8px;">Send us a note</div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
          <div>
            <label class="iiq-field-label" for="iiq-first">First name<span class="iiq-required"> *</span></label>
            <input class="iiq-input" id="iiq-first" name="first" type="text" required>
          </div>
          <div>
            <label class="iiq-field-label" for="iiq-last">Last name<span class="iiq-required"> *</span></label>
            <input class="iiq-input" id="iiq-last" name="last" type="text" required>
          </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
          <div>
            <label class="iiq-field-label" for="iiq-email">Work email<span class="iiq-required"> *</span></label>
            <input class="iiq-input" id="iiq-email" name="email" type="email" required>
          </div>
          <div>
            <label class="iiq-field-label" for="iiq-company">Company<span class="iiq-required"> *</span></label>
            <input class="iiq-input" id="iiq-company" name="company" type="text" required>
          </div>
        </div>

        <div>
          <label class="iiq-field-label" for="iiq-role">Role</label>
          <input class="iiq-input" id="iiq-role" name="role" type="text" placeholder="e.g. CEO, Head of Operations">
        </div>

        <div>
          <label class="iiq-field-label" for="iiq-topic">What brings you here?</label>
          <select class="iiq-select" id="iiq-topic" name="topic">
            <option value="" disabled selected>Select one&hellip;</option>
            <?php foreach ($topics as $t): ?>
              <option value="<?= esc_attr($t) ?>"><?= esc_html($t) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="iiq-field-label" for="iiq-message">Tell us about your business</label>
          <textarea class="iiq-textarea" id="iiq-message" name="message" rows="4" placeholder="Number of locations, systems you run today, what you&rsquo;re trying to fix&hellip;"></textarea>
        </div>

        <div style="margin-top:8px;padding-top:24px;border-top:1px solid var(--border-default);display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
          <span style="font-size:13px;color:var(--fg-tertiary);">We respond within one business day.</span>
          <button type="submit" style="appearance:none;border:none;cursor:pointer;background:var(--ignite-500);color:var(--ink-50);font-family:var(--font-display);font-weight:500;font-size:16px;letter-spacing:-0.01em;text-transform:none;padding:14px 28px;border-radius:4px;display:inline-flex;align-items:center;gap:8px;">Send message <span style="font-size:14px;">&rarr;</span></button>
        </div>
      </form>
    </div>

  </div>
</section>
