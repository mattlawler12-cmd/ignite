/**
 * IgniteIQ — IntersectionObserver-based reveal animation.
 *
 * Ports Reveal.jsx. Toggles `.is-visible` on `[data-reveal]` elements when
 * they enter the viewport. Honors prefers-reduced-motion.
 */
(() => {
  const els = document.querySelectorAll('[data-reveal]');
  if (!els.length) return;

  // Flag the document so the CSS hidden state takes effect.
  document.documentElement.classList.add('iiq-js-reveal');

  // No IntersectionObserver support → reveal everything immediately.
  if (typeof IntersectionObserver === 'undefined') {
    els.forEach((el) => el.classList.add('is-visible'));
    return;
  }

  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    els.forEach((el) => el.classList.add('is-visible'));
    return;
  }

  const io = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const delay = parseInt(el.dataset.revealDelay || '0', 10);
      if (delay > 0) {
        setTimeout(() => el.classList.add('is-visible'), delay);
      } else {
        el.classList.add('is-visible');
      }
      io.unobserve(el);
    });
  }, { rootMargin: '0px 0px 0px 0px', threshold: 0.01 });

  els.forEach((el) => io.observe(el));

  // Safety net — if anything is still hidden 4 seconds after load, force-reveal it.
  // Covers fast scroll past sections, observer race conditions, or sub-page anchor jumps.
  window.addEventListener('load', () => {
    setTimeout(() => {
      document.querySelectorAll('[data-reveal]:not(.is-visible)').forEach((el) => {
        const r = el.getBoundingClientRect();
        if (r.top < window.innerHeight) el.classList.add('is-visible');
      });
    }, 800);
  });
})();
