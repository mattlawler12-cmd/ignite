(function(){
/* global React, Reveal */

// ─────────────────────────────────────────────────────────────────────
// Isometric stack diagram — Data → Logic → Actions
// Cream background, four stacked diamond planes with side annotations.
// Inspired by Palantir's Operations stack diagram.
// ─────────────────────────────────────────────────────────────────────
function PlatformStackDiagram() {
  const cream = '#FFFFFF';
  const ink = 'var(--ink-1000)';
  const accent = 'var(--ignite-500)';

  // Geometry: each plane is a rhombus centered at (cx, cy) with halfW × halfH.
  // Same shape, vertically offset.
  const cx = 500;
  const halfW = 300; // horizontal radius (leaves room for side labels)
  const halfH = 120; // vertical radius (controls isometric flatness)
  const planeY = [140, 320, 500]; // 3 planes — overlap by ~60px so they layer

  // Returns rhombus polygon points for a plane centered at (cx, cy)
  const rhombus = (cx, cy, w, h) => `${cx},${cy - h} ${cx + w},${cy} ${cx},${cy + h} ${cx - w},${cy}`;

  // Edge midpoints — useful for connector anchors
  // Right edge midpoint of rhombus = (cx + halfW/2, cy + halfH/2) — actually it's the right vertex (cx+halfW, cy)
  // For our connector lines we'll attach to the right vertex and left vertex of each plane.

  return /*#__PURE__*/React.createElement("section", {
    style: {
      padding: '110px 32px 120px',
      background: cream,
      borderTop: '1px solid var(--border-subtle)',
      borderBottom: '1px solid var(--border-subtle)',
      position: 'relative',
      overflow: 'hidden'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 1240,
      margin: '0 auto',
      position: 'relative'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 16,
      paddingBottom: 64,
      fontFamily: 'var(--font-mono)',
      fontSize: 11,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      color: 'var(--fg-tertiary)'
    }
  }, /*#__PURE__*/React.createElement("span", null, "02"), /*#__PURE__*/React.createElement("span", null, "The stack")), /*#__PURE__*/React.createElement(Reveal, null, /*#__PURE__*/React.createElement("h2", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 'clamp(40px, 5.2vw, 76px)',
      fontWeight: 600,
      letterSpacing: '-0.04em',
      lineHeight: 1.0,
      margin: '0 auto',
      color: ink,
      textAlign: 'center',
      maxWidth: 900
    }
  }, "The most intelligent ", /*#__PURE__*/React.createElement("span", {
    style: {
      color: accent
    }
  }, "infrastructure"), " in home services")), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 36,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      gap: 12,
      flexWrap: 'wrap'
    }
  }, [['DATA', 'INFORMATION'], ['LOGIC', 'INTELLIGENCE'], ['ACTIONS', 'OUTCOMES']].map(([k, v], i) => /*#__PURE__*/React.createElement(React.Fragment, {
    key: k
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '12px 20px',
      border: `1.5px solid ${i === 1 ? accent : ink}`,
      color: i === 1 ? accent : ink,
      background: 'transparent',
      fontFamily: 'var(--font-mono)',
      fontSize: 11,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      fontWeight: 600,
      display: 'flex',
      alignItems: 'center',
      gap: 8,
      borderRadius: 2
    }
  }, /*#__PURE__*/React.createElement("span", null, k), /*#__PURE__*/React.createElement("span", {
    style: {
      opacity: 0.55
    }
  }, "[", v, "]")), i < 2 && /*#__PURE__*/React.createElement("div", {
    style: {
      width: 30,
      height: 30,
      borderRadius: '50%',
      border: `1.4px solid ${ink}`,
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      color: ink,
      fontFamily: 'var(--font-mono)',
      fontWeight: 600,
      fontSize: 14
    }
  }, "+")))), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 56,
      position: 'relative',
      width: '100%',
      maxWidth: 780,
      margin: '56px auto 0'
    }
  }, /*#__PURE__*/React.createElement("svg", {
    viewBox: "0 0 1000 720",
    width: "100%",
    style: {
      display: 'block',
      overflow: 'visible'
    }
  }, /*#__PURE__*/React.createElement("defs", null, /*#__PURE__*/React.createElement("linearGradient", {
    id: "igniteGrad",
    x1: "0%",
    y1: "0%",
    x2: "100%",
    y2: "0%"
  }, /*#__PURE__*/React.createElement("stop", {
    offset: "0%",
    stopColor: "oklch(58% 0.232 25)",
    stopOpacity: "0.95"
  }), /*#__PURE__*/React.createElement("stop", {
    offset: "50%",
    stopColor: "oklch(70% 0.18 30)",
    stopOpacity: "0.55"
  }), /*#__PURE__*/React.createElement("stop", {
    offset: "100%",
    stopColor: "oklch(80% 0.12 35)",
    stopOpacity: "0.05"
  }))), /*#__PURE__*/React.createElement("polygon", {
    points: rhombus(cx, planeY[2], halfW, halfH),
    fill: "url(#igniteGrad)",
    stroke: "oklch(58% 0.232 25)",
    strokeWidth: "1.2"
  }), /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("polygon", {
    points: rhombus(cx, planeY[1], halfW, halfH),
    fill: cream,
    stroke: ink,
    strokeWidth: "1.2"
  }), (() => {
    const T = {
      x: cx,
      y: planeY[1] - halfH
    };
    const R = {
      x: cx + halfW,
      y: planeY[1]
    };
    const B = {
      x: cx,
      y: planeY[1] + halfH
    };
    const L = {
      x: cx - halfW,
      y: planeY[1]
    };
    const lerp = (a, b, t) => ({
      x: a.x + (b.x - a.x) * t,
      y: a.y + (b.y - a.y) * t
    });
    const lines = [];
    [0.2, 0.4, 0.6, 0.8].forEach((t, i) => {
      const p1 = lerp(L, T, t);
      const p2 = lerp(B, R, t);
      lines.push(/*#__PURE__*/React.createElement("line", {
        key: `p${i}`,
        x1: p1.x,
        y1: p1.y,
        x2: p2.x,
        y2: p2.y,
        stroke: ink,
        strokeWidth: "0.9"
      }));
    });
    [0.2, 0.4, 0.6, 0.8].forEach((t, i) => {
      const p1 = lerp(T, R, t);
      const p2 = lerp(L, B, t);
      lines.push(/*#__PURE__*/React.createElement("line", {
        key: `q${i}`,
        x1: p1.x,
        y1: p1.y,
        x2: p2.x,
        y2: p2.y,
        stroke: ink,
        strokeWidth: "0.9"
      }));
    });
    return lines;
  })()), /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("polygon", {
    points: rhombus(cx, planeY[0], halfW, halfH),
    fill: ink,
    stroke: ink,
    strokeWidth: "1.4"
  }), [0.85, 0.68, 0.50, 0.32, 0.16].map((s, i) => /*#__PURE__*/React.createElement("polygon", {
    key: i,
    points: rhombus(cx, planeY[0], halfW * s, halfH * s),
    fill: "none",
    stroke: "oklch(38% 0.01 286)",
    strokeWidth: "0.9",
    opacity: "0.85"
  }))), /*#__PURE__*/React.createElement("line", {
    x1: cx - halfW,
    y1: planeY[0],
    x2: 105,
    y2: planeY[0],
    stroke: ink,
    strokeWidth: "1.2"
  }), /*#__PURE__*/React.createElement("line", {
    x1: cx + halfW,
    y1: planeY[1],
    x2: 895,
    y2: planeY[1],
    stroke: ink,
    strokeWidth: "1.2"
  }), /*#__PURE__*/React.createElement("line", {
    x1: cx - halfW,
    y1: planeY[2],
    x2: 105,
    y2: planeY[2],
    stroke: ink,
    strokeWidth: "1.2"
  }), /*#__PURE__*/React.createElement("g", {
    fontFamily: "var(--font-display)",
    fontSize: "20",
    fontWeight: "600",
    letterSpacing: "-0.01em"
  }, /*#__PURE__*/React.createElement("text", {
    x: "910",
    y: planeY[1] - 6,
    fill: ink
  }, "Your"), /*#__PURE__*/React.createElement("text", {
    x: "910",
    y: planeY[1] + 18,
    fill: ink
  }, "logic"), /*#__PURE__*/React.createElement("text", {
    x: "90",
    y: planeY[0] - 6,
    fill: ink,
    textAnchor: "end"
  }, "Your decisions"), /*#__PURE__*/React.createElement("text", {
    x: "90",
    y: planeY[0] + 18,
    fill: ink,
    textAnchor: "end"
  }, "& actions"), /*#__PURE__*/React.createElement("text", {
    x: "90",
    y: planeY[2] - 6,
    fill: accent,
    textAnchor: "end"
  }, "Your"), /*#__PURE__*/React.createElement("text", {
    x: "90",
    y: planeY[2] + 18,
    fill: accent,
    textAnchor: "end"
  }, "data")))), /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'grid',
      gridTemplateColumns: 'repeat(3, 1fr)',
      gap: 48,
      paddingTop: 32,
      borderTop: `1px solid ${ink}`,
      maxWidth: 1100,
      margin: '64px auto 0'
    }
  }, [['DATA', '[Information]', 'Your cloud warehouse — Snowflake, BigQuery, or Databricks. 25+ operational systems sync in: ServiceTitan, FieldEdge, accounting, marketing, telephony. Raw, staged, marted. Always under your IAM, never copied out.'], ['LOGIC', '[Intelligence]', 'The ontology — twelve resolved entities (job, technician, lead, invoice, customer, equipment) that compose every business question. The shared object model that lets agents and operators speak the same language as the data.'], ['ACTIONS', '[Outcomes]', 'Chat, signals, agents, decisions. The surface where operators ask, are told, and act. Every action is grounded in the ontology and writes back through the systems your team already uses.']].map(([k, v, body], i) => /*#__PURE__*/React.createElement(Reveal, {
    key: k,
    delay: i * 100
  }, /*#__PURE__*/React.createElement("div", null, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-mono)',
      fontSize: 11,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      color: i === 1 ? accent : ink,
      fontWeight: 600
    }
  }, k, " ", /*#__PURE__*/React.createElement("span", {
    style: {
      opacity: 0.55
    }
  }, v)), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 18,
      fontSize: 15,
      lineHeight: 1.55,
      color: ink,
      margin: '18px 0 0'
    }
  }, body)))))));
}
window.PlatformStackDiagram = PlatformStackDiagram;
})();
