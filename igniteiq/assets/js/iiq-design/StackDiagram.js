(function(){
/* global React */
// Architecture Stack Diagram — IgniteIQ
// Isometric four-platform stack: Intel / Signal / Agents on top,
// Ontology in the middle, Data + Models on the bottom.
// Built as pure SVG. All styling in IgniteIQ palette.

function ArchStackDiagram({
  index,
  label = 'The stack',
  headerLabel = 'How it all fits together',
  headlineLeft = 'One model of your business.',
  headlineRight = 'Every product, every object, every system reads from it.',
  body = 'IgniteIQ deploys a data warehouse inside your cloud, unifies every operational system into a single ontology, and runs AI products on top of it. The whole stack is built to do one thing - make every decision your business makes sharper than the one before it.',
  closingLine = null
} = {}) {
  // ─── Palette ───────────────────────────────────────────────
  const ink = '#0F0F12'; // primary ink
  const inkSoft = '#5A5A60'; // secondary
  const line = '#C9C5BD'; // platform stroke
  const lineSoft = '#E2DDD2'; // hairline
  const cream = '#FFFFFF'; // platform top
  const creamSide = '#F4EFE4'; // platform side (depth)
  const accent = '#E11D2E'; // IgniteIQ red
  const accentBg = '#FBE0DD'; // accent pill bg

  // ─── Helper: isometric platform ────────────────────────────
  function Platform({
    cx,
    cy,
    w,
    h
  }) {
    const top = [[cx, cy - h / 2], [cx + w / 2, cy], [cx, cy + h / 2], [cx - w / 2, cy]];
    const depth = 14;
    const side = [[cx - w / 2, cy], [cx, cy + h / 2], [cx + w / 2, cy], [cx + w / 2, cy + depth], [cx, cy + h / 2 + depth], [cx - w / 2, cy + depth]];
    return /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("ellipse", {
      cx: cx,
      cy: cy + h / 2 + depth + 12,
      rx: w / 2 - 24,
      ry: 5,
      fill: "black",
      opacity: "0.05"
    }), /*#__PURE__*/React.createElement("polygon", {
      points: side.map(p => p.join(',')).join(' '),
      fill: creamSide,
      stroke: line,
      strokeWidth: "1"
    }), /*#__PURE__*/React.createElement("polygon", {
      points: top.map(p => p.join(',')).join(' '),
      fill: cream,
      stroke: line,
      strokeWidth: "1.25"
    }));
  }

  // ─── Helper: pill-shaped relationship label ────────────────
  function Pill({
    x,
    y,
    label,
    hot = false
  }) {
    const w = label.length * 6.4 + 22;
    const h = 19;
    return /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("rect", {
      x: x - w / 2,
      y: y - h / 2,
      width: w,
      height: h,
      rx: h / 2,
      ry: h / 2,
      fill: hot ? accentBg : 'white',
      stroke: hot ? accent : line,
      strokeWidth: "1"
    }), /*#__PURE__*/React.createElement("text", {
      x: x,
      y: y + 3.5,
      textAnchor: "middle",
      fontFamily: "ui-monospace, 'SF Mono', monospace",
      fontSize: "9.5",
      fontWeight: "600",
      fill: hot ? accent : ink,
      letterSpacing: "0.06em"
    }, label));
  }

  // ─── Helper: section caption (above/below platform) ────────
  function Caption({
    x,
    y,
    label,
    sub,
    tight
  }) {
    return /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("text", {
      x: x,
      y: y,
      textAnchor: "middle",
      fontFamily: "var(--font-display), serif",
      fontSize: tight ? 16 : 22,
      fontWeight: "700",
      fill: ink,
      letterSpacing: tight ? '0.16em' : '0.22em'
    }, label), sub && /*#__PURE__*/React.createElement("text", {
      x: x,
      y: y + 18,
      textAnchor: "middle",
      fontFamily: "ui-monospace, 'SF Mono', monospace",
      fontSize: "10",
      fill: inkSoft,
      letterSpacing: "0.16em"
    }, sub));
  }

  // ─── Helper: a tiny "screen" sketch on top of a platform ───
  function MiniCard({
    x,
    y,
    w,
    h,
    kind
  }) {
    return /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("rect", {
      x: x + 2,
      y: y + 2,
      width: w,
      height: h,
      rx: "2",
      fill: "black",
      opacity: "0.04"
    }), /*#__PURE__*/React.createElement("rect", {
      x: x,
      y: y,
      width: w,
      height: h,
      rx: "2",
      fill: "white",
      stroke: line,
      strokeWidth: "1"
    }), /*#__PURE__*/React.createElement("rect", {
      x: x,
      y: y,
      width: w,
      height: "6",
      rx: "2",
      fill: creamSide
    }), kind === 'chart' && /*#__PURE__*/React.createElement("polyline", {
      points: `${x + 6},${y + h - 8} ${x + 14},${y + h - 14} ${x + 22},${y + h - 11} ${x + 30},${y + h - 20} ${x + 38},${y + h - 16} ${x + w - 6},${y + h - 24}`,
      fill: "none",
      stroke: ink,
      strokeWidth: "1.2"
    }), kind === 'chart' && /*#__PURE__*/React.createElement("circle", {
      cx: x + w - 6,
      cy: y + h - 24,
      r: "2.5",
      fill: accent
    }), kind === 'bars' && [10, 18, 14, 22, 16].map((bh, i) => /*#__PURE__*/React.createElement("rect", {
      key: i,
      x: x + 6 + i * 8,
      y: y + h - bh - 4,
      width: "5",
      height: bh,
      fill: i === 3 ? accent : ink,
      opacity: i === 3 ? 1 : 0.4
    })), kind === 'alert' && /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("rect", {
      x: x + 6,
      y: y + 12,
      width: w - 12,
      height: "6",
      rx: "1",
      fill: accentBg,
      stroke: accent,
      strokeWidth: "0.6"
    }), /*#__PURE__*/React.createElement("rect", {
      x: x + 6,
      y: y + 22,
      width: (w - 12) * 0.6,
      height: "4",
      rx: "1",
      fill: ink,
      opacity: "0.4"
    }), /*#__PURE__*/React.createElement("rect", {
      x: x + 6,
      y: y + 30,
      width: (w - 12) * 0.4,
      height: "4",
      rx: "1",
      fill: ink,
      opacity: "0.25"
    })), kind === 'agent' && /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("circle", {
      cx: x + w / 2,
      cy: y + 18,
      r: "6",
      stroke: ink,
      fill: "white",
      strokeWidth: "0.9"
    }), /*#__PURE__*/React.createElement("rect", {
      x: x + w / 2 - 9,
      y: y + 27,
      width: "18",
      height: "9",
      rx: "1.5",
      fill: accentBg,
      stroke: accent,
      strokeWidth: "0.6"
    })), kind === 'data' && [0, 1, 2, 3].map(i => /*#__PURE__*/React.createElement("ellipse", {
      key: i,
      cx: x + w / 2,
      cy: y + 12 + i * 6,
      rx: w / 2 - 8,
      ry: "2.5",
      fill: i === 1 ? accentBg : 'white',
      stroke: ink,
      strokeWidth: "0.7"
    })), kind === 'model' && /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("circle", {
      cx: x + 12,
      cy: y + 14,
      r: "2.5",
      fill: ink
    }), /*#__PURE__*/React.createElement("circle", {
      cx: x + 28,
      cy: y + 14,
      r: "2.5",
      fill: ink
    }), /*#__PURE__*/React.createElement("circle", {
      cx: x + 20,
      cy: y + 28,
      r: "2.5",
      fill: accent
    }), /*#__PURE__*/React.createElement("circle", {
      cx: x + 36,
      cy: y + 28,
      r: "2.5",
      fill: ink
    }), /*#__PURE__*/React.createElement("line", {
      x1: x + 12,
      y1: y + 14,
      x2: x + 20,
      y2: y + 28,
      stroke: inkSoft,
      strokeWidth: "0.6"
    }), /*#__PURE__*/React.createElement("line", {
      x1: x + 28,
      y1: y + 14,
      x2: x + 20,
      y2: y + 28,
      stroke: inkSoft,
      strokeWidth: "0.6"
    }), /*#__PURE__*/React.createElement("line", {
      x1: x + 28,
      y1: y + 14,
      x2: x + 36,
      y2: y + 28,
      stroke: inkSoft,
      strokeWidth: "0.6"
    })));
  }

  // ─── Helper: entity (circle on the central platform) ───────
  function Entity({
    x,
    y,
    glyph
  }) {
    return /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("circle", {
      cx: x,
      cy: y,
      r: "20",
      fill: "white",
      stroke: ink,
      strokeWidth: "1.1"
    }), /*#__PURE__*/React.createElement("text", {
      x: x,
      y: y + 4,
      textAnchor: "middle",
      fontFamily: "ui-monospace, 'SF Mono', monospace",
      fontSize: "10",
      fontWeight: "700",
      fill: ink,
      letterSpacing: "0.05em"
    }, glyph));
  }

  // ─── Helper: bundle of curved dashed lines (a "flow") ──────
  function FlowBundle({
    fromX1,
    fromX2,
    fromY,
    toX1,
    toX2,
    toY,
    count = 16,
    hot = false,
    arrowAtTop = false
  }) {
    const color = hot ? accent : inkSoft;
    const opacity = hot ? 0.7 : 0.55;
    const dots = [];
    const lines = [];
    const arrows = [];
    for (let i = 0; i < count; i++) {
      const t = i / (count - 1);
      const fx = fromX1 + (fromX2 - fromX1) * t;
      const tx = toX1 + (toX2 - toX1) * t;
      const my = (fromY + toY) / 2;
      const d = `M ${fx} ${fromY} C ${fx} ${my}, ${tx} ${my}, ${tx} ${toY}`;
      lines.push(/*#__PURE__*/React.createElement("path", {
        key: i,
        d: d,
        fill: "none",
        stroke: color,
        strokeWidth: "0.7",
        strokeDasharray: "1 3.5",
        opacity: opacity
      }));
      dots.push(/*#__PURE__*/React.createElement("circle", {
        key: `d${i}`,
        cx: tx,
        cy: toY,
        r: "1.4",
        fill: color,
        opacity: opacity + 0.1
      }));
      if (arrowAtTop) {
        // small upward chevron at the top end of each line, every other line so it stays subtle
        if (i % 2 === 0) {
          arrows.push(/*#__PURE__*/React.createElement("path", {
            key: `a${i}`,
            d: `M ${fx - 2.2} ${fromY + 3} L ${fx} ${fromY} L ${fx + 2.2} ${fromY + 3}`,
            fill: "none",
            stroke: color,
            strokeWidth: "0.9",
            strokeLinecap: "round",
            strokeLinejoin: "round",
            opacity: opacity + 0.2
          }));
        }
      }
    }
    return /*#__PURE__*/React.createElement("g", null, lines, dots, arrows);
  }
  return /*#__PURE__*/React.createElement("section", {
    style: {
      padding: '120px 32px 140px',
      background: 'var(--bg-canvas)',
      borderTop: '1px solid var(--border-subtle)',
      borderBottom: '1px solid var(--border-subtle)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      maxWidth: 1320,
      margin: '0 auto'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      alignItems: 'center',
      gap: 16,
      fontFamily: 'var(--font-mono)',
      fontSize: 11,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      color: 'var(--fg-tertiary)'
    }
  }, index ? /*#__PURE__*/React.createElement("span", null, index) : null, /*#__PURE__*/React.createElement("span", null, headerLabel)), /*#__PURE__*/React.createElement("h2", {
    style: {
      fontFamily: 'var(--font-display)',
      fontSize: 'clamp(40px, 5.6vw, 76px)',
      fontWeight: 600,
      letterSpacing: '-0.04em',
      lineHeight: 0.98,
      margin: '20px 0 0',
      maxWidth: 1100,
      color: 'var(--fg-primary)'
    }
  }, headlineLeft, /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--fg-tertiary)'
    }
  }, " ", headlineRight)), /*#__PURE__*/React.createElement("p", {
    style: {
      marginTop: 28,
      maxWidth: 760,
      fontSize: 19,
      lineHeight: 1.55,
      color: 'var(--fg-secondary)'
    }
  }, body), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 80,
      maxWidth: 1056,
      marginLeft: 'auto',
      marginRight: 'auto'
    }
  }, /*#__PURE__*/React.createElement("svg", {
    viewBox: "0 0 1280 960",
    width: "100%",
    style: {
      display: 'block'
    }
  }, /*#__PURE__*/React.createElement(Caption, {
    x: 240,
    y: 50,
    label: "ANALYTICS & BI",
    sub: "UNDERSTAND",
    tight: true
  }), /*#__PURE__*/React.createElement(Caption, {
    x: 640,
    y: 50,
    label: "WORKFLOWS & AUTOMATIONS",
    sub: "ACTIONS",
    tight: true
  }), /*#__PURE__*/React.createElement(Caption, {
    x: 1040,
    y: 50,
    label: "AGENTIC AGENTS & TOOLS",
    sub: "AGENTIC INTELLIGENCE",
    tight: true
  }), /*#__PURE__*/React.createElement(Platform, {
    cx: 240,
    cy: 170,
    w: 300,
    h: 120
  }), /*#__PURE__*/React.createElement(Platform, {
    cx: 640,
    cy: 170,
    w: 300,
    h: 120
  }), /*#__PURE__*/React.createElement(Platform, {
    cx: 1040,
    cy: 170,
    w: 300,
    h: 120
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 170,
    y: 120,
    w: 68,
    h: 42,
    kind: "chart"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 250,
    y: 130,
    w: 56,
    h: 32,
    kind: "bars"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 570,
    y: 120,
    w: 68,
    h: 42,
    kind: "alert"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 650,
    y: 132,
    w: 60,
    h: 32,
    kind: "alert"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 970,
    y: 120,
    w: 56,
    h: 42,
    kind: "agent"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 1036,
    y: 130,
    w: 56,
    h: 36,
    kind: "agent"
  }), /*#__PURE__*/React.createElement(FlowBundle, {
    fromX1: 150,
    fromX2: 330,
    fromY: 210,
    toX1: 300,
    toX2: 460,
    toY: 400,
    count: 14
  }), /*#__PURE__*/React.createElement(FlowBundle, {
    fromX1: 550,
    fromX2: 730,
    fromY: 210,
    toX1: 560,
    toX2: 720,
    toY: 400,
    count: 14
  }), /*#__PURE__*/React.createElement(FlowBundle, {
    fromX1: 950,
    fromX2: 1130,
    fromY: 210,
    toX1: 820,
    toX2: 980,
    toY: 400,
    count: 14,
    hot: true
  }), /*#__PURE__*/React.createElement(Platform, {
    cx: 640,
    cy: 460,
    w: 920,
    h: 180
  }), /*#__PURE__*/React.createElement("g", {
    transform: "translate(186, 380)"
  }, /*#__PURE__*/React.createElement("rect", {
    x: "0",
    y: "0",
    width: "170",
    height: "70",
    rx: "3",
    fill: "white",
    stroke: ink,
    strokeWidth: "1"
  }), /*#__PURE__*/React.createElement("text", {
    x: "12",
    y: "18",
    fontFamily: "ui-monospace, 'SF Mono', monospace",
    fontSize: "10",
    fontWeight: "700",
    fill: ink,
    letterSpacing: "0.08em"
  }, "JOB N\xBA 4827"), /*#__PURE__*/React.createElement("line", {
    x1: "12",
    y1: "24",
    x2: "158",
    y2: "24",
    stroke: lineSoft
  }), [['Tech', 'M. Reyes'], ['Region', 'Phoenix'], ['Margin', '$ 412']].map(([k, v], i) => /*#__PURE__*/React.createElement("g", {
    key: k
  }, /*#__PURE__*/React.createElement("text", {
    x: "12",
    y: 37 + i * 12,
    fontFamily: "ui-monospace, 'SF Mono', monospace",
    fontSize: "9",
    fill: inkSoft
  }, k), /*#__PURE__*/React.createElement("text", {
    x: "158",
    y: 37 + i * 12,
    textAnchor: "end",
    fontFamily: "ui-monospace, 'SF Mono', monospace",
    fontSize: "9",
    fontWeight: "600",
    fill: ink
  }, v))), /*#__PURE__*/React.createElement("line", {
    x1: "170",
    y1: "32",
    x2: "244",
    y2: "60",
    stroke: inkSoft,
    strokeWidth: "0.8",
    strokeDasharray: "2 3"
  }), /*#__PURE__*/React.createElement("circle", {
    cx: 244,
    cy: 60,
    r: "2",
    fill: accent
  })), (() => {
    const cx = 640,
      cy = 460,
      w = 920,
      h = 180;
    const halfW = w / 2,
      halfH = h / 2;
    const margin = 0.08; // shrink mask 8%
    const cols = 17;
    const rows = 7;
    const stepX = (w - 60) / (cols - 1);
    const stepY = (h - 20) / (rows - 1);
    const startX = cx - (cols - 1) * stepX / 2;
    const startY = cy - (rows - 1) * stepY / 2;
    const points = [];
    const grid = {};
    for (let r = 0; r < rows; r++) {
      for (let c = 0; c < cols; c++) {
        const px = startX + c * stepX;
        const py = startY + r * stepY;
        const dx = (px - cx) / halfW;
        const dy = (py - cy) / halfH;
        if (Math.abs(dx) + Math.abs(dy) > 1 - margin) continue;
        const isX = (r + c) % 2 === 0;
        // sparse red accents — deterministic positions
        const accentSet = new Set([`1-5`, `2-9`, `3-12`, `4-6`, `4-13`, `2-3`, `5-8`]);
        const isAccent = accentSet.has(`${r}-${c}`);
        const p = {
          r,
          c,
          px,
          py,
          isX,
          isAccent
        };
        points.push(p);
        grid[`${r}-${c}`] = p;
      }
    }

    // Web of connections — for every point, connect to its
    // right, down, down-right, and down-left neighbours when
    // they exist. That gives an interlocking diamond mesh.
    const conns = [];
    const accentEdges = new Set(['1-5_2-6', '2-9_3-10', '3-12_4-13', '4-6_5-7', '2-3_3-4', '5-8_6-9']);
    for (const p of points) {
      const neighbours = [[p.r, p.c + 1], [p.r + 1, p.c], [p.r + 1, p.c + 1], [p.r + 1, p.c - 1]];
      for (const [nr, nc] of neighbours) {
        const q = grid[`${nr}-${nc}`];
        if (!q) continue;
        const key1 = `${p.r}-${p.c}_${nr}-${nc}`;
        const isAccentEdge = p.isAccent && q.isAccent || accentEdges.has(key1);
        conns.push([p, q, isAccentEdge]);
      }
    }
    return /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("g", {
      fill: "none"
    }, conns.map(([a, b, hot], i) => /*#__PURE__*/React.createElement("line", {
      key: i,
      x1: a.px,
      y1: a.py,
      x2: b.px,
      y2: b.py,
      stroke: hot ? accent : inkSoft,
      strokeOpacity: hot ? 0.55 : 0.28,
      strokeWidth: hot ? 0.7 : 0.55,
      strokeDasharray: "0.8 2.4"
    }))), points.map(({
      r,
      c,
      px,
      py,
      isX,
      isAccent
    }) => {
      const color = isAccent ? accent : ink;
      const size = 3;
      return isX ? /*#__PURE__*/React.createElement("g", {
        key: `g-${r}-${c}`,
        stroke: color,
        strokeWidth: "1",
        strokeLinecap: "round"
      }, /*#__PURE__*/React.createElement("line", {
        x1: px - size,
        y1: py - size,
        x2: px + size,
        y2: py + size
      }), /*#__PURE__*/React.createElement("line", {
        x1: px - size,
        y1: py + size,
        x2: px + size,
        y2: py - size
      })) : /*#__PURE__*/React.createElement("circle", {
        key: `g-${r}-${c}`,
        cx: px,
        cy: py,
        r: size,
        fill: "white",
        stroke: color,
        strokeWidth: "1"
      });
    }));
  })(), /*#__PURE__*/React.createElement("text", {
    x: 640,
    y: 632,
    textAnchor: "middle",
    fontFamily: "var(--font-display)",
    fontSize: "34",
    fontWeight: "800",
    fill: ink,
    letterSpacing: "0.30em"
  }, "ONTOLOGY"), /*#__PURE__*/React.createElement("text", {
    x: 640,
    y: 656,
    textAnchor: "middle",
    fontFamily: "var(--font-mono)",
    fontSize: "11",
    fill: inkSoft,
    letterSpacing: "0.14em"
  }, "THE NOUNS, VERBS, AND DATA RELATIONSHIPS OF HOW YOUR BUSINESS ACTUALLY RUNS"), /*#__PURE__*/React.createElement(FlowBundle, {
    fromX1: 300,
    fromX2: 460,
    fromY: 540,
    toX1: 150,
    toX2: 330,
    toY: 760,
    count: 14,
    arrowAtTop: true
  }), /*#__PURE__*/React.createElement(FlowBundle, {
    fromX1: 560,
    fromX2: 720,
    fromY: 540,
    toX1: 550,
    toX2: 730,
    toY: 760,
    count: 14,
    arrowAtTop: true
  }), /*#__PURE__*/React.createElement(FlowBundle, {
    fromX1: 820,
    fromX2: 980,
    fromY: 540,
    toX1: 950,
    toX2: 1130,
    toY: 760,
    count: 14,
    hot: true,
    arrowAtTop: true
  }), /*#__PURE__*/React.createElement(Platform, {
    cx: 240,
    cy: 780,
    w: 300,
    h: 120
  }), /*#__PURE__*/React.createElement(Platform, {
    cx: 640,
    cy: 780,
    w: 300,
    h: 120
  }), /*#__PURE__*/React.createElement(Platform, {
    cx: 1040,
    cy: 780,
    w: 300,
    h: 120
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 170,
    y: 732,
    w: 68,
    h: 42,
    kind: "data"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 250,
    y: 744,
    w: 56,
    h: 32,
    kind: "data"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 570,
    y: 732,
    w: 68,
    h: 42,
    kind: "model"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 650,
    y: 744,
    w: 60,
    h: 32,
    kind: "model"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 970,
    y: 732,
    w: 56,
    h: 42,
    kind: "agent"
  }), /*#__PURE__*/React.createElement(MiniCard, {
    x: 1036,
    y: 744,
    w: 56,
    h: 36,
    kind: "agent"
  }), /*#__PURE__*/React.createElement(Caption, {
    x: 240,
    y: 905,
    label: "DATA",
    sub: "FSM \xB7 OPS \xB7 FINANCE",
    tight: true
  }), /*#__PURE__*/React.createElement(Caption, {
    x: 640,
    y: 905,
    label: "MODELS & LOGIC",
    sub: "SCORING \xB7 RESOLUTION \xB7 FORECAST",
    tight: true
  }), /*#__PURE__*/React.createElement(Caption, {
    x: 1040,
    y: 905,
    label: "ACTIONS",
    sub: "WRITE-BACK \xB7 DISPATCH \xB7 NOTIFY",
    tight: true
  }))), /*#__PURE__*/React.createElement("div", {
    style: {
      marginTop: 48,
      paddingTop: 56,
      paddingBottom: 24,
      borderTop: '1px solid var(--border-subtle)',
      display: 'flex',
      flexDirection: 'column',
      alignItems: 'center',
      textAlign: 'center'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      fontFamily: 'var(--font-mono)',
      fontSize: 11,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      color: 'var(--fg-tertiary)',
      marginBottom: 24,
      display: 'flex',
      alignItems: 'center',
      gap: 12
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      width: 24,
      height: 1,
      background: 'var(--border-default)'
    }
  }), /*#__PURE__*/React.createElement("span", null, "The point"), /*#__PURE__*/React.createElement("span", {
    style: {
      width: 24,
      height: 1,
      background: 'var(--border-default)'
    }
  })), /*#__PURE__*/React.createElement("h3", {
    style: {
      margin: 0,
      maxWidth: 880,
      fontFamily: 'var(--font-display)',
      fontSize: 'clamp(28px, 3.4vw, 44px)',
      lineHeight: 1.2,
      letterSpacing: '-0.02em',
      fontWeight: 400,
      color: 'var(--fg-primary)',
      textWrap: 'balance'
    }
  }, (function () {
    // FIDELITY: when a string `closingLine` is passed (e.g. Ontology page
    // \u2014 "Your business makes a thousand decisions a day. We make every
    // one faster, smarter, and right."), split on the first `". "` and
    // render the second sentence in italic --fg-tertiary, mirroring
    // Ontology.js:584-589 which wraps the second clause in <em>.
    if (!closingLine) {
      return /*#__PURE__*/React.createElement(React.Fragment, null, "Every decision \u2014", ' ', /*#__PURE__*/React.createElement("em", {
        style: { fontStyle: 'italic', color: 'var(--fg-tertiary)' }
      }, "faster, smarter, and right."));
    }
    if (typeof closingLine !== 'string') return closingLine;
    var idx = closingLine.indexOf('. ');
    if (idx === -1) return closingLine;
    var first = closingLine.slice(0, idx + 1);
    var second = closingLine.slice(idx + 2);
    return /*#__PURE__*/React.createElement(React.Fragment, null, first, ' ', /*#__PURE__*/React.createElement("em", {
      style: { fontStyle: 'italic', color: 'var(--fg-tertiary)' }
    }, second));
  })()))));
}
window.ArchStackDiagram = ArchStackDiagram;
})();
