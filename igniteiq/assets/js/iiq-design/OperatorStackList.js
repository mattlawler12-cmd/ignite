(function(){
/* global React */
// Operator Stack — IgniteIQ
// Lifted byte-accurately from SectionsA.js ProblemSection right-column panel
// (the "Operator stack · today" badges grid + dashed-bottom callout stats).
// Source: exports/latest/js/SectionsA.js lines 116-181 (Reveal-wrapped panel
// inside ProblemSection). This component renders ONLY the inner panel — the
// surrounding section + headline are provided by the WordPress section_split
// template-part that hosts it.

function OperatorStackList() {
  const systems = ['ServiceTitan', 'FieldEdge', 'Housecall Pro', 'QuickBooks', 'Xero', 'Salesforce', 'HubSpot', 'Google Ads', 'Meta Ads', 'CallRail', 'Stripe', 'Gusto', 'ADP', 'Sheets', 'Mailchimp', 'Podium', 'SmartRecruiters', 'BambooHR', 'Slack', 'Zapier', '+5 more'];
  return /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      padding: '32px 28px',
      borderRadius: 10,
      border: '1px solid var(--border-default)',
      background: 'var(--bg-surface)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-mono)',
      fontSize: 10,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      color: 'var(--fg-tertiary)',
      marginBottom: 16
    }
  }, "Operator stack \xB7 today"), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      flexWrap: 'wrap',
      gap: 6
    }
  }, systems.map((s, i) => /*#__PURE__*/React.createElement("span", {
    key: s,
    style: {
      fontFamily: 'var(--font-sans)',
      fontSize: 12,
      fontWeight: 500,
      padding: '6px 12px',
      borderRadius: 4,
      border: '1px solid var(--border-subtle)',
      background: i === systems.length - 1 ? 'transparent' : '#fff',
      color: i === systems.length - 1 ? 'var(--fg-tertiary)' : 'var(--fg-secondary)'
    }
  }, s))), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 28,
      paddingTop: 22,
      borderTop: '1px dashed var(--border-default)'
    }
  }, [['0', 'shared definition of a job'], ['4', 'different IDs for the same customer'], ['2 wks', 'to answer "which channel actually pays"']].map(([n, t]) => /*#__PURE__*/React.createElement("div", {
    key: t,
    style: {
      display: 'flex',
      alignItems: 'baseline',
      gap: 14,
      marginTop: 8
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 32,
      fontWeight: 700,
      letterSpacing: '-0.025em',
      color: 'var(--fg-primary)',
      minWidth: 80
    }
  }, n), /*#__PURE__*/React.createElement("span", {
    style: {
      fontSize: 14,
      color: 'var(--fg-secondary)'
    }
  }, t)))));
}
window.OperatorStackList = OperatorStackList;
})();
