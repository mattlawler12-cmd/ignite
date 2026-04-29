// Mount lifted React components into [data-iiq-design] placeholders.
// Reads optional [data-iiq-props] (JSON-encoded) for per-mount overrides.
(function () {
  function mount() {
    if (!window.React || !window.ReactDOM) {
      console.warn('[iiq-design] React not loaded yet, retrying…');
      setTimeout(mount, 50);
      return;
    }
    var registry = {
      'stack-diagram':  window.ArchStackDiagram,
      'platform-stack': window.PlatformStackDiagram,
      'arch-ontology':  window.ArchOntologyScene,
      'operator-stack': window.OperatorStackList,
      'boundary':       window.BoundaryDiagram
    };
    document.querySelectorAll('[data-iiq-design]').forEach(function (el) {
      if (el.__iiqMounted) return;
      var key = el.getAttribute('data-iiq-design');
      var Comp = registry[key];
      if (!Comp) { console.warn('[iiq-design] unknown component:', key); return; }
      var props = {};
      var raw = el.getAttribute('data-iiq-props');
      if (raw) {
        try { props = JSON.parse(raw); }
        catch (e) { console.warn('[iiq-design] bad props JSON:', e); }
      }
      ReactDOM.createRoot(el).render(React.createElement(Comp, props));
      el.__iiqMounted = true;
    });
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mount);
  } else {
    mount();
  }
})();
