(function(){
/* global React, Reveal, Eyebrow */
// Boundary Diagram — IgniteIQ
// Lifted byte-accurately from Architecture.js ArchCompoundingDiagram (lines
// 579-671 of exports/latest/js/Architecture.js). The original is wrapped in a
// `Block` section helper that adds an "06 / What compounds" index+label and
// "Customer data stays put. The framework gets smarter." headline. On the
// IgniteIQ company page this diagram is hosted inside the section_split
// right-column slot, where the section frame + headline are provided by the
// WP split template-part — so we expose ONLY the inner two-column boundary
// card (Stays in customer cloud / Compounds in framework).
//
// FIDELITY EXCEPTION: the original `Block` wrapper's index="06" / label=
// "What compounds" / outer headline are intentionally NOT rendered here —
// they live in the WP split template-part's section header. The two cards
// below are byte-for-byte identical to the export.

function BoundaryDiagram() {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: '1fr 1fr',
      gap: 32
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '36px 32px',
      background: '#fff',
      borderRadius: 12,
      border: '1px solid var(--border-default)'
    }
  }, /*#__PURE__*/React.createElement(Eyebrow, null, "Stays in customer cloud"), /*#__PURE__*/React.createElement("h3", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 26,
      fontWeight: 600,
      letterSpacing: '-0.025em',
      margin: '16px 0 24px'
    }
  }, "Operational data"), ['Tables · raw + modeled', 'Identity & access policies', 'Customer records · job records · invoices', 'Audit logs · query history'].map(x => /*#__PURE__*/React.createElement("div", {
    key: x,
    style: {
      padding: '10px 0',
      borderTop: '1px solid var(--border-subtle)',
      fontSize: 14,
      color: 'var(--fg-secondary)'
    }
  }, x))), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '36px 32px',
      background: 'var(--ink-1000)',
      color: 'var(--ink-50)',
      borderRadius: 12,
      position: 'relative',
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      inset: 0,
      background: 'radial-gradient(circle at 70% 30%, oklch(57.5% 0.232 25 / 0.18), transparent 60%)',
      pointerEvents: 'none'
    }
  }), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement(Eyebrow, {
    color: "var(--ignite-400)"
  }, "Compounds in framework"), /*#__PURE__*/React.createElement("h3", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 26,
      fontWeight: 600,
      letterSpacing: '-0.025em',
      margin: '16px 0 24px',
      color: 'var(--ink-50)'
    }
  }, "Patterns & intelligence"), ['Edge cases · resolution rules', 'Integration shape · vendor quirks', 'Decision heuristics · agent prompts', 'Benchmark distributions · anonymized'].map(x => /*#__PURE__*/React.createElement("div", {
    key: x,
    style: {
      padding: '10px 0',
      borderTop: '1px solid oklch(22% 0.005 286)',
      fontSize: 14,
      color: 'oklch(75% 0.005 286)'
    }
  }, x)))));
}
window.BoundaryDiagram = BoundaryDiagram;
})();
