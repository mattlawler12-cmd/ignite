/**
 * IgniteIQ — minimal scroll parallax for hero decorative elements.
 *
 * Targets [data-iiq-parallax-coefficient="N"] and applies translateY based
 * on viewport scroll. Honors prefers-reduced-motion.
 */
(() => {
  const els = Array.from(document.querySelectorAll('[data-iiq-parallax-coefficient]'));
  if (!els.length) return;

  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  // Disable on small viewports — parallax breaks the static stack layout when grids collapse to 1-col
  if (window.innerWidth < 900) return;

  const map = els.map((el) => ({ el, c: parseFloat(el.dataset.iiqParallaxCoefficient) || 0 }));

  let ticking = false;
  const update = () => {
    const y = window.scrollY;
    for (const { el, c } of map) {
      el.style.transform = `translate3d(0, ${(-y * c).toFixed(2)}px, 0)`;
    }
    ticking = false;
  };

  const onScroll = () => {
    if (!ticking) {
      ticking = true;
      requestAnimationFrame(update);
    }
  };

  update();
  window.addEventListener('scroll', onScroll, { passive: true });
})();
