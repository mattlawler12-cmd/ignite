(function(){
function _extends() { return _extends = Object.assign ? Object.assign.bind() : function (n) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e]; for (var r in t) ({}).hasOwnProperty.call(t, r) && (n[r] = t[r]); } return n; }, _extends.apply(null, arguments); }
/* global React */
const {
  useEffect,
  useRef,
  useState
} = React;

// Pure CSS reveal — no JS state. Element starts at opacity 0 + translateY(y),
// CSS keyframes animate to final position. Always works, no observers.
function Reveal({
  children,
  delay = 0,
  y = 16,
  as = 'div',
  style = {},
  ...rest
}) {
  const Tag = as;
  return /*#__PURE__*/React.createElement(Tag, _extends({
    style: style
  }, rest), children);
}
function Eyebrow({
  children,
  color,
  style = {}
}) {
  return /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-mono)',
      fontSize: 11,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      color: color || 'var(--ignite-500)',
      display: 'inline-flex',
      alignItems: 'center',
      gap: 8,
      ...style
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 6,
      height: 6,
      background: 'var(--ignite-500)',
      display: 'inline-block',
      animation: 'iiqPulse 2s ease-in-out infinite'
    }
  }), children);
}
function SectionFrame({
  index,
  label,
  children,
  dark,
  style = {},
  padBottom = true
}) {
  return /*#__PURE__*/React.createElement("section", {
    style: {
      position: 'relative',
      padding: padBottom ? '120px 32px 140px' : '120px 32px 0',
      background: dark ? 'var(--ink-1000)' : 'transparent',
      color: dark ? 'var(--ink-50)' : 'var(--fg-primary)',
      borderTop: dark ? '1px solid oklch(20% 0.005 286)' : '1px solid var(--border-subtle)',
      ...style
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 1320,
      margin: '0 auto',
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'absolute',
      top: -120,
      left: 0,
      padding: '20px 0',
      display: 'flex',
      alignItems: 'center',
      gap: 16,
      fontFamily: 'var(--font-mono)',
      fontSize: 11,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      color: dark ? 'oklch(50% 0.005 286)' : 'var(--fg-tertiary)'
    }
  }, /*#__PURE__*/React.createElement("span", null, index), /*#__PURE__*/React.createElement("span", null, label)), children));
}
window.Reveal = Reveal;
window.Eyebrow = Eyebrow;
window.SectionFrame = SectionFrame;
})();
