/**
 * IgniteIQ — primary nav behavior.
 *
 * Ports Nav.jsx state machine: scroll-aware backdrop blur on the bar,
 * burger toggles the side drawer at <=860px with body-scroll-lock.
 */
(() => {
  const nav    = document.querySelector('[data-iiq-nav]');
  const burger = document.querySelector('[data-iiq-nav-burger]');
  const drawer = document.querySelector('[data-iiq-nav-drawer]');
  const scrim  = document.querySelector('[data-iiq-nav-scrim]');
  const close  = document.querySelector('[data-iiq-nav-close]');
  if (!nav) return;

  const inverse = nav.dataset.inverse === '1';
  const bgScrolled = inverse ? 'oklch(7.5% 0.003 286 / 0.85)' : 'oklch(98.6% 0.001 286 / 0.85)';
  const borderScrolled = inverse ? '1px solid oklch(20% 0.005 286)' : '1px solid var(--border-subtle)';

  const onScroll = () => {
    const scrolled = window.scrollY > 8;
    nav.style.background = scrolled ? bgScrolled : 'transparent';
    nav.style.backdropFilter = scrolled ? 'blur(12px)' : 'none';
    nav.style.webkitBackdropFilter = scrolled ? 'blur(12px)' : 'none';
    nav.style.borderBottom = scrolled ? borderScrolled : '1px solid transparent';
  };
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  if (!burger || !drawer) return;

  let open = false;
  let lockedScrollY = 0;

  const lockBody = () => {
    lockedScrollY = window.scrollY;
    document.body.classList.add('iiq-nav-locked');
    document.body.style.position = 'fixed';
    document.body.style.top = `-${lockedScrollY}px`;
    document.body.style.left = '0';
    document.body.style.right = '0';
    document.body.style.width = '100%';
  };
  const unlockBody = () => {
    document.body.classList.remove('iiq-nav-locked');
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.left = '';
    document.body.style.right = '';
    document.body.style.width = '';
    window.scrollTo(0, lockedScrollY);
  };

  const setOpen = (v) => {
    open = !!v;
    drawer.classList.toggle('is-open', open);
    if (scrim) scrim.classList.toggle('is-open', open);
    burger.setAttribute('aria-expanded', String(open));
    drawer.setAttribute('aria-hidden', String(!open));
    if (open) lockBody(); else unlockBody();
  };

  burger.addEventListener('click', () => setOpen(true));
  close && close.addEventListener('click', () => setOpen(false));
  scrim && scrim.addEventListener('click', () => setOpen(false));

  drawer.querySelectorAll('a').forEach((a) =>
    a.addEventListener('click', () => setOpen(false))
  );

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && open) setOpen(false);
  });

  // If viewport widens past breakpoint while drawer is open, close it.
  const mq = window.matchMedia('(min-width: 861px)');
  mq.addEventListener('change', (e) => {
    if (e.matches && open) setOpen(false);
  });
})();
