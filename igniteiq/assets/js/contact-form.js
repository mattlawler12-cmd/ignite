/**
 * IgniteIQ — contact form submit handler.
 *
 * Submits to admin-ajax.php (action=iiq_contact). On success, swaps the
 * form node for a confirmation message — matches the JSX setSubmitted(true)
 * UX from Contact.jsx.
 */
(() => {
  const form = document.querySelector('[data-iiq-contact-form]');
  if (!form) return;
  if (typeof IIQ_CONTACT === 'undefined') return;

  const renderedAt = form.querySelector('[name="rendered_at"]');
  if (renderedAt) renderedAt.value = String(Math.floor(Date.now() / 1000));

  // Border-bottom focus color toggle, matching JSX field behavior.
  form.querySelectorAll('.iiq-input, .iiq-select, .iiq-textarea').forEach((el) => {
    el.addEventListener('focus', () => { el.style.borderBottomColor = 'var(--ignite-500)'; });
    el.addEventListener('blur', () => { el.style.borderBottomColor = ''; });
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const submit = form.querySelector('button[type="submit"]');
    if (submit) { submit.disabled = true; submit.dataset.originalText = submit.textContent; submit.textContent = 'Sending…'; }

    const data = new FormData(form);
    data.append('action', 'iiq_contact');
    data.append('nonce', IIQ_CONTACT.nonce);

    try {
      const res = await fetch(IIQ_CONTACT.ajax, { method: 'POST', body: data, credentials: 'same-origin' });
      const json = await res.json();
      if (json && json.success) {
        renderConfirmation();
      } else {
        showError(json && json.data && json.data.message ? json.data.message : 'Something went wrong.');
      }
    } catch (err) {
      showError('Network error. Please try again.');
    } finally {
      if (submit) { submit.disabled = false; if (submit.dataset.originalText) submit.textContent = submit.dataset.originalText; }
    }
  });

  function renderConfirmation() {
    // Mirror the static [data-iiq-contact-success] block in
    // template-parts/forms/contact.php — byte-accurate to Contact.js.
    // Plain prose (no inline links) per the export's JSX.
    const wrap = document.createElement('div');
    wrap.setAttribute('role', 'status');
    wrap.setAttribute('aria-live', 'polite');
    wrap.style.cssText = 'padding:40px 0;';
    wrap.innerHTML =
      '<div style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--ignite-500);">● Received</div>' +
      '<h2 style="font-family:var(--font-display);font-size:36px;font-weight:600;letter-spacing:-0.03em;line-height:1.1;margin:20px 0 0;color:var(--fg-primary);">Thanks. We’ll be in touch.</h2>' +
      '<p style="margin-top:16px;font-size:16px;line-height:1.55;color:var(--fg-secondary);max-width:540px;">Someone on our team will reach out within one business day. In the meantime, feel free to see how it works, or read about the ontology.</p>';
    form.replaceWith(wrap);
  }

  function showError(message) {
    let err = form.querySelector('[data-iiq-form-error]');
    if (!err) {
      err = document.createElement('div');
      err.setAttribute('data-iiq-form-error', '');
      err.style.cssText = 'margin-top:16px;padding:12px 16px;background:oklch(96% 0.04 25);color:oklch(38% 0.18 25);font-size:14px;border-left:2px solid var(--ignite-500);';
      form.appendChild(err);
    }
    err.textContent = message;
  }

  function escapeHtml(s) {
    return String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  }
})();
