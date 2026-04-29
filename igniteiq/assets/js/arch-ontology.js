(() => {
  const root = document.querySelector('[data-iiq-arch-scene]');
  if (!root) return;
  const pills = root.querySelectorAll('[data-iiq-pill]');
  const setActive = (id, on) => {
    if (!id) return;
    root.querySelectorAll(`[data-iiq-pill="${id}"], [data-iiq-connector="${id}"], [data-iiq-target="${id}"]`)
      .forEach(el => el.classList.toggle('iiq-arch-active', on));
  };
  pills.forEach(p => {
    const id = p.dataset.iiqPill;
    p.addEventListener('mouseenter', () => setActive(id, true));
    p.addEventListener('mouseleave', () => setActive(id, false));
    p.addEventListener('focus', () => setActive(id, true));
    p.addEventListener('blur', () => setActive(id, false));
  });
})();
