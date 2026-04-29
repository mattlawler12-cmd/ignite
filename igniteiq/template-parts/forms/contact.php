<?php
if (!defined('ABSPATH')) exit;

/**
 * Contact form — static markup, submitted via /assets/js/contact-form.js
 * to admin-ajax (action=iiq_contact). Spam mitigation: nonce, honeypot, time-trap.
 *
 * Style match for Contact.jsx Field/SelectField/TextareaField — border-bottom
 * inputs, monospace uppercase labels, focus turns border to ignite-500.
 */

$topics = [
    'I want a demo',
    'Evaluating vs another platform',
    'Partnership',
    'Press',
    'Other',
];

$nonce = wp_create_nonce('iiq_contact');

// Office data — pulled from Site Settings ACF group with JSX defaults as fallback.
$contact_email = function_exists('iiq_setting') ? iiq_setting('contact_email', 'hello@igniteiq.com') : 'hello@igniteiq.com';
$contact_phone = function_exists('iiq_setting') ? iiq_setting('contact_phone', '') : '';
?>
<section data-reveal class="iiq-pad iiq-section-pad" style="padding:120px 32px 160px;background:var(--bg-canvas);">
  <div style="max-width:1320px;margin:0 auto;display:grid;grid-template-columns:0.9fr 1.4fr;gap:96px;" class="iiq-grid-split">

    <aside>
      <div style="margin-bottom:48px;">
        <h3 style="font-size:14px;font-family:'Aeonik Fono',monospace;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);margin:0 0 12px;">Direct</h3>
        <?php if ($contact_email): ?>
          <a href="mailto:<?= esc_attr($contact_email) ?>" style="display:block;font-family:'Aeonik',sans-serif;font-size:20px;color:var(--fg-primary);text-decoration:none;margin-bottom:6px;"><?= esc_html($contact_email) ?></a>
        <?php endif; ?>
        <?php if ($contact_phone): ?>
          <a href="tel:<?= esc_attr(preg_replace('/[^0-9+]/', '', $contact_phone)) ?>" style="display:block;font-family:'Aeonik',sans-serif;font-size:20px;color:var(--fg-primary);text-decoration:none;"><?= esc_html($contact_phone) ?></a>
        <?php endif; ?>
      </div>

      <div>
        <h3 style="font-size:14px;font-family:'Aeonik Fono',monospace;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);margin:0 0 16px;">Offices</h3>
        <div style="margin-bottom:32px;">
          <h4 style="font-size:24px;font-weight:500;margin:0 0 6px;">San Diego</h4>
          <span style="display:inline-block;padding:2px 8px;font-family:'Aeonik Fono',monospace;font-size:10px;letter-spacing:0.14em;text-transform:uppercase;color:var(--fg-tertiary);border:1px solid var(--border-default);margin-bottom:8px;">HQ</span>
          <p style="margin:0;color:var(--fg-secondary);font-size:14px;line-height:1.6;">501 W Broadway<br>San Diego, CA 92101</p>
        </div>
        <div>
          <h4 style="font-size:24px;font-weight:500;margin:0 0 6px;">San Francisco</h4>
          <p style="margin:0;color:var(--fg-secondary);font-size:14px;line-height:1.6;">535 Mission St<br>San Francisco, CA 94105</p>
        </div>
      </div>
    </aside>

    <form data-iiq-contact-form method="post" action="<?= esc_url(admin_url('admin-ajax.php')) ?>" novalidate style="display:flex;flex-direction:column;gap:24px;">
      <input type="hidden" name="action" value="iiq_contact">
      <input type="hidden" name="nonce" value="<?= esc_attr($nonce) ?>">
      <input type="hidden" name="rendered_at" value="0">

      <div class="iiq-honeypot" aria-hidden="true">
        <label>Website (leave blank)<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
        <div>
          <label class="iiq-field-label" for="iiq-first">First<span class="iiq-required">*</span></label>
          <input class="iiq-input" id="iiq-first" name="first" type="text" required>
        </div>
        <div>
          <label class="iiq-field-label" for="iiq-last">Last<span class="iiq-required">*</span></label>
          <input class="iiq-input" id="iiq-last" name="last" type="text" required>
        </div>
      </div>

      <div>
        <label class="iiq-field-label" for="iiq-email">Email<span class="iiq-required">*</span></label>
        <input class="iiq-input" id="iiq-email" name="email" type="email" required>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
        <div>
          <label class="iiq-field-label" for="iiq-company">Company<span class="iiq-required">*</span></label>
          <input class="iiq-input" id="iiq-company" name="company" type="text" required>
        </div>
        <div>
          <label class="iiq-field-label" for="iiq-role">Role</label>
          <input class="iiq-input" id="iiq-role" name="role" type="text">
        </div>
      </div>

      <div>
        <label class="iiq-field-label" for="iiq-topic">Topic</label>
        <select class="iiq-select" id="iiq-topic" name="topic">
          <option value="" disabled selected>Select one…</option>
          <?php foreach ($topics as $t): ?>
            <option value="<?= esc_attr($t) ?>"><?= esc_html($t) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="iiq-field-label" for="iiq-message">Message</label>
        <textarea class="iiq-textarea" id="iiq-message" name="message" rows="4" placeholder="A few words about what you're working on."></textarea>
      </div>

      <div style="margin-top:16px;">
        <button type="submit" class="iiq-btn">Send</button>
      </div>
    </form>

  </div>
</section>
