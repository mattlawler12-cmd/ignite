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
        renderConfirmation(json.data && json.data.message ? json.data.message : 'Thanks — we got your note.');
      } else {
        showError(json && json.data && json.data.message ? json.data.message : 'Something went wrong.');
      }
    } catch (err) {
      showError('Network error. Please try again.');
    } finally {
      if (submit) { submit.disabled = false; if (submit.dataset.originalText) submit.textContent = submit.dataset.originalText; }
    }
  });

  function renderConfirmation(message) {
    const wrap = document.createElement('div');
    wrap.setAttribute('role', 'status');
    wrap.setAttribute('aria-live', 'polite');
    wrap.style.cssText = 'padding:32px 0;font-family:Aeonik,sans-serif;font-size:18px;color:var(--fg-primary);';
    wrap.innerHTML = `<p style="margin:0 0 12px;font-weight:500;">${escapeHtml(message)}</p><p style="margin:0;color:var(--fg-secondary);font-size:14px;">We'll be in touch from a real human, usually within a business day.</p>`;
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
