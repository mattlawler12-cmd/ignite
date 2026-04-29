(function(){
/* global React */
const {
  useState
} = React;

// ─────────────────────────────────────────────────────────────────────
// ArchOntologyScene — isometric line-art "service area" with capability
// pills connecting to specific objects. Brand: IgniteIQ monochrome.
//
// Coordinate system: ONE unified SVG viewBox (1200×760). No inner
// transforms — every primitive is drawn at the same coordinate as its
// pill target so the connectors land on visible objects.
// ─────────────────────────────────────────────────────────────────────
function ArchOntologyScene() {
  const [hover, setHover] = useState(null);
  const stroke = 'var(--fg-primary)';
  const strokeMid = 'var(--fg-secondary)';
  const strokeLite = 'var(--border-default)';
  const sw = 1.25;

  // Object draw centers (must match what each Iso* primitive renders at)
  const objs = {
    job: {
      x: 320,
      y: 440
    },
    // job-site pin
    customer: {
      x: 230,
      y: 490
    },
    // customer house
    tech: {
      x: 440,
      y: 410
    },
    // technician figure
    truck: {
      x: 600,
      y: 380
    },
    // service truck
    invoice: {
      x: 740,
      y: 410
    },
    // paper stack
    call: {
      x: 870,
      y: 410
    },
    // call tower
    property: {
      x: 970,
      y: 460
    },
    // small house cluster right
    membership: {
      x: 860,
      y: 510
    } // membership card
  };

  // Pills along the top — staggered into two rows like the reference
  const pills = [{
    id: 'job',
    label: 'JOB',
    x: 90,
    row: 0
  }, {
    id: 'customer',
    label: 'CUSTOMER',
    x: 215,
    row: 1
  }, {
    id: 'tech',
    label: 'TECHNICIAN',
    x: 340,
    row: 0
  }, {
    id: 'truck',
    label: 'TRUCK',
    x: 480,
    row: 1
  }, {
    id: 'invoice',
    label: 'INVOICE',
    x: 605,
    row: 0
  }, {
    id: 'call',
    label: 'CALL',
    x: 745,
    row: 1
  }, {
    id: 'property',
    label: 'PROPERTY',
    x: 870,
    row: 0
  }, {
    id: 'membership',
    label: 'MEMBERSHIP',
    x: 1000,
    row: 1
  }];
  return /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      borderRadius: 14,
      border: '1px solid var(--border-default)',
      background: 'var(--bg-sunken)',
      overflow: 'hidden',
      boxShadow: '0 30px 60px -30px oklch(7.5% 0.003 286 / 0.18)'
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'center',
      padding: '14px 22px',
      borderBottom: '1px solid var(--border-subtle)',
      background: 'var(--bg-canvas, #fff)',
      fontFamily: 'var(--font-mono)',
      fontSize: 11,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      color: 'var(--fg-tertiary)'
    }
  }, /*#__PURE__*/React.createElement("span", null, "YOUR DATA WAREHOUSE"), /*#__PURE__*/React.createElement("span", {
    style: {
      display: 'inline-flex',
      alignItems: 'center',
      gap: 8,
      color: 'var(--ignite-500)'
    }
  }, "\u25CF V4.2")), /*#__PURE__*/React.createElement("div", {
    style: {
      position: 'relative',
      width: '100%',
      aspectRatio: '1200 / 600'
    }
  }, /*#__PURE__*/React.createElement("svg", {
    viewBox: "0 0 1200 600",
    xmlns: "http://www.w3.org/2000/svg",
    style: {
      position: 'absolute',
      inset: 0,
      width: '100%',
      height: '100%',
      display: 'block'
    },
    "aria-label": "IgniteIQ ontology scene"
  }, pills.map(p => {
    const y = p.row === 0 ? 30 : 78;
    const target = objs[p.id];
    const isHover = hover === p.id;
    return /*#__PURE__*/React.createElement("g", {
      key: p.id,
      onMouseEnter: () => setHover(p.id),
      onMouseLeave: () => setHover(null),
      style: {
        cursor: 'default'
      }
    }, /*#__PURE__*/React.createElement("rect", {
      x: p.x,
      y: y,
      width: 106,
      height: 32,
      rx: 3,
      fill: "var(--bg-canvas, #fff)",
      stroke: isHover ? 'var(--ignite-500)' : stroke,
      strokeWidth: sw
    }), /*#__PURE__*/React.createElement("text", {
      x: p.x + 53,
      y: y + 21,
      textAnchor: "middle",
      fontFamily: "var(--font-mono)",
      fontSize: "11",
      letterSpacing: "2",
      fill: isHover ? 'var(--ignite-500)' : stroke
    }, p.label), /*#__PURE__*/React.createElement(Connector, {
      x1: p.x + 53,
      y1: y + 32,
      x2: target.x,
      y2: target.y,
      stroke: isHover ? 'var(--ignite-500)' : strokeMid,
      strokeWidth: isHover ? 1.4 : 1
    }), /*#__PURE__*/React.createElement("circle", {
      cx: target.x,
      cy: target.y,
      r: isHover ? 4 : 3,
      fill: isHover ? 'var(--ignite-500)' : stroke
    }));
  }), /*#__PURE__*/React.createElement(IsoPlatformTopHalf, {
    cx: 600,
    cy: 500,
    w: 920,
    h: 240,
    stroke: stroke,
    sw: sw
  }), /*#__PURE__*/React.createElement(IsoBuilding, {
    cx: 600,
    cy: 440,
    w: 140,
    h: 70,
    d: 50,
    stroke: stroke,
    sw: sw,
    variant: "hq"
  }), /*#__PURE__*/React.createElement(IsoJobSite, {
    cx: objs.job.x,
    cy: objs.job.y,
    stroke: stroke,
    sw: sw
  }), /*#__PURE__*/React.createElement(IsoHouse, {
    cx: objs.customer.x,
    cy: objs.customer.y,
    stroke: stroke,
    sw: sw
  }), /*#__PURE__*/React.createElement(IsoTech, {
    cx: objs.tech.x,
    cy: objs.tech.y,
    stroke: stroke,
    sw: sw
  }), /*#__PURE__*/React.createElement(IsoTruck, {
    cx: objs.truck.x,
    cy: objs.truck.y,
    stroke: stroke,
    sw: sw
  }), /*#__PURE__*/React.createElement(IsoInvoice, {
    cx: objs.invoice.x,
    cy: objs.invoice.y,
    stroke: stroke,
    sw: sw
  }), /*#__PURE__*/React.createElement(IsoCallTower, {
    cx: objs.call.x,
    cy: objs.call.y,
    stroke: stroke,
    sw: sw
  }), /*#__PURE__*/React.createElement(IsoHouse, {
    cx: objs.property.x,
    cy: objs.property.y,
    stroke: stroke,
    sw: sw,
    small: true
  }), /*#__PURE__*/React.createElement(IsoMembership, {
    cx: objs.membership.x,
    cy: objs.membership.y,
    stroke: stroke,
    sw: sw
  }), /*#__PURE__*/React.createElement(IsoSilo, {
    cx: 150,
    cy: 490,
    stroke: strokeLite,
    sw: 1
  }), /*#__PURE__*/React.createElement(IsoTree, {
    cx: 1080,
    cy: 520,
    stroke: strokeLite,
    sw: 1
  }), /*#__PURE__*/React.createElement("g", {
    transform: "translate(1000 560)"
  }, /*#__PURE__*/React.createElement("rect", {
    x: "-30",
    y: "-12",
    width: "60",
    height: "22",
    rx: "2",
    fill: stroke
  }), /*#__PURE__*/React.createElement("text", {
    x: "0",
    y: "3",
    textAnchor: "middle",
    fontFamily: "var(--font-mono)",
    fontSize: "10",
    letterSpacing: "1.5",
    fill: "var(--bg-canvas, #fff)"
  }, "prod"))), /*#__PURE__*/React.createElement(InspectorCallout, null)), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '20px 32px',
      borderTop: '1px solid var(--border-default)',
      background: 'var(--bg-canvas, #fff)',
      display: 'flex',
      justifyContent: 'center',
      alignItems: 'center',
      gap: 18,
      flexWrap: 'wrap'
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      fontFamily: 'var(--font-mono)',
      fontSize: 10,
      letterSpacing: '0.18em',
      textTransform: 'uppercase',
      color: 'var(--ignite-500)'
    }
  }, "\u25CF Built on your cloud"), /*#__PURE__*/React.createElement("span", {
    style: {
      fontSize: 13,
      color: 'var(--fg-secondary)'
    }
  }, "Every line of business \u2014 every job, customer, technician, truck \u2014 resolved into one model that lives in your warehouse and is queried by the framework.")));
}

// Right-angle elbow connector
function Connector({
  x1,
  y1,
  x2,
  y2,
  stroke,
  strokeWidth
}) {
  const midY = y1 + Math.max(40, (y2 - y1) * 0.35);
  const d = `M${x1},${y1} L${x1},${midY} L${x2},${midY} L${x2},${y2}`;
  return /*#__PURE__*/React.createElement("path", {
    d: d,
    fill: "none",
    stroke: stroke,
    strokeWidth: strokeWidth,
    strokeLinecap: "square"
  });
}

// ─── Iso primitives — all use cx/cy as the anchor point ────────────

// Platform with only the TOP HALF visible — like the reference image,
// where the bottom of the diamond is cropped off below the frame.
function IsoPlatformTopHalf({
  cx,
  cy,
  w,
  h,
  stroke,
  sw
}) {
  const half = w / 2,
    halfH = h / 2;
  // top-half path: left → top peak → right → cropped flat bottom (no bottom point)
  const path = `M${cx - half},${cy} L${cx},${cy - halfH} L${cx + half},${cy}`;
  return /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("path", {
    d: path,
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), Array.from({
    length: 5
  }).map((_, i) => {
    const t = (i + 1) / 6;
    return /*#__PURE__*/React.createElement("g", {
      key: i,
      stroke: "var(--border-default)",
      strokeWidth: "0.6",
      opacity: "0.6"
    }, /*#__PURE__*/React.createElement("line", {
      x1: cx - half + t * half,
      y1: cy - t * halfH,
      x2: cx + t * half,
      y2: cy - halfH + t * halfH
    }));
  }));
}
function IsoBuilding({
  cx,
  cy,
  w,
  h,
  d,
  stroke,
  sw,
  variant
}) {
  // cy = front-bottom anchor
  const left = cx - w / 2,
    right = cx + w / 2;
  const topY = cy - h;
  const sideOffset = d * 0.5;
  return /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("path", {
    d: `M${left},${cy} L${left},${topY} L${left - sideOffset},${topY - sideOffset * 0.55}
        L${left - sideOffset},${cy - sideOffset * 0.55} Z`,
    fill: "var(--bg-sunken)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("path", {
    d: `M${right},${cy} L${right},${topY} L${right + sideOffset},${topY - sideOffset * 0.55}
        L${right + sideOffset},${cy - sideOffset * 0.55} Z`,
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("path", {
    d: `M${left},${cy} L${right},${cy} L${right},${topY} L${left},${topY} Z`,
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), variant === 'hq' && /*#__PURE__*/React.createElement("g", {
    stroke: stroke,
    strokeWidth: sw,
    fill: "var(--bg-canvas, #fff)"
  }, /*#__PURE__*/React.createElement("rect", {
    x: cx - 18,
    y: topY - 26,
    width: "9",
    height: "26"
  }), /*#__PURE__*/React.createElement("rect", {
    x: cx + 8,
    y: topY - 36,
    width: "9",
    height: "36"
  })), /*#__PURE__*/React.createElement("g", {
    stroke: stroke,
    strokeWidth: "0.8",
    fill: "none"
  }, [0, 1, 2].map(c => /*#__PURE__*/React.createElement("g", {
    key: c
  }, /*#__PURE__*/React.createElement("rect", {
    x: left + 14 + c * 42,
    y: topY + 16,
    width: "26",
    height: "12"
  }), /*#__PURE__*/React.createElement("rect", {
    x: left + 14 + c * 42,
    y: topY + 44,
    width: "26",
    height: "12"
  })))));
}
function IsoHouse({
  cx,
  cy,
  stroke,
  sw,
  small
}) {
  const w = small ? 50 : 70;
  const h = small ? 32 : 44;
  const d = small ? 28 : 38;
  const left = cx - w / 2,
    right = cx + w / 2,
    topY = cy - h;
  const peakY = topY - 18;
  return /*#__PURE__*/React.createElement("g", null, /*#__PURE__*/React.createElement("path", {
    d: `M${left},${cy} L${right},${cy} L${right},${topY} L${left},${topY} Z`,
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("path", {
    d: `M${right},${cy} L${right + d * 0.5},${cy - d * 0.28}
        L${right + d * 0.5},${topY - d * 0.28} L${right},${topY} Z`,
    fill: "var(--bg-sunken)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("path", {
    d: `M${left},${topY} L${right},${topY} L${right + d * 0.5},${topY - d * 0.28}
        L${(left + right) / 2 + d * 0.25},${peakY - d * 0.14}
        L${(left + right) / 2 - d * 0.25},${peakY} Z`,
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("rect", {
    x: left + w * 0.4,
    y: cy - h * 0.55,
    width: w * 0.2,
    height: h * 0.55,
    fill: "var(--bg-sunken)",
    stroke: stroke,
    strokeWidth: "0.8"
  }), !small && /*#__PURE__*/React.createElement("rect", {
    x: left + w * 0.12,
    y: topY + h * 0.2,
    width: w * 0.2,
    height: h * 0.28,
    fill: "none",
    stroke: stroke,
    strokeWidth: "0.8"
  }));
}
function IsoTruck({
  cx,
  cy,
  stroke,
  sw
}) {
  return /*#__PURE__*/React.createElement("g", {
    transform: `translate(${cx} ${cy})`
  }, /*#__PURE__*/React.createElement("ellipse", {
    cx: "0",
    cy: "14",
    rx: "38",
    ry: "5",
    fill: "var(--border-subtle)",
    opacity: "0.6"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M-32,2 L8,2 L8,-28 L-32,-28 Z",
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("path", {
    d: "M8,2 L20,-4 L20,-34 L-32,-34 L-32,-28 L8,-28 Z",
    fill: "var(--bg-sunken)",
    stroke: stroke,
    strokeWidth: sw,
    opacity: "0.95"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M8,2 L26,2 L26,-14 L20,-14 L20,-4 L8,-4 Z",
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("circle", {
    cx: "-22",
    cy: "4",
    r: "5",
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("circle", {
    cx: "-2",
    cy: "4",
    r: "5",
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("circle", {
    cx: "20",
    cy: "4",
    r: "5",
    fill: "var(--bg-canvas, #fff)",
    stroke: stroke,
    strokeWidth: sw
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-28",
    y1: "-12",
    x2: "4",
    y2: "-12",
    stroke: stroke,
    strokeWidth: "0.8"
  }));
}
function IsoTech({
  cx,
  cy,
  stroke,
  sw
}) {
  return /*#__PURE__*/React.createElement("g", {
    transform: `translate(${cx} ${cy})`,
    stroke: stroke,
    strokeWidth: sw,
    fill: "var(--bg-canvas, #fff)"
  }, /*#__PURE__*/React.createElement("ellipse", {
    cx: "0",
    cy: "22",
    rx: "10",
    ry: "3",
    fill: "var(--border-subtle)",
    stroke: "none",
    opacity: "0.7"
  }), /*#__PURE__*/React.createElement("circle", {
    cx: "0",
    cy: "-12",
    r: "5"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M-5,-8 L-7,8 L7,8 L5,-8 Z"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-5",
    y1: "8",
    x2: "-6",
    y2: "22"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "5",
    y1: "8",
    x2: "6",
    y2: "22"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-5",
    y1: "-14",
    x2: "5",
    y2: "-14"
  }));
}
function IsoJobSite({
  cx,
  cy,
  stroke,
  sw
}) {
  return /*#__PURE__*/React.createElement("g", {
    transform: `translate(${cx} ${cy})`,
    stroke: stroke,
    strokeWidth: sw,
    fill: "var(--bg-canvas, #fff)"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M-28,8 L0,-6 L28,8 L0,22 Z",
    fill: "var(--bg-sunken)"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M0,-30 C-9,-30 -14,-22 -14,-16 C-14,-8 0,4 0,4 C0,4 14,-8 14,-16 C14,-22 9,-30 0,-30 Z"
  }), /*#__PURE__*/React.createElement("circle", {
    cx: "0",
    cy: "-17",
    r: "4",
    fill: "var(--bg-sunken)"
  }));
}
function IsoInvoice({
  cx,
  cy,
  stroke,
  sw
}) {
  return /*#__PURE__*/React.createElement("g", {
    transform: `translate(${cx} ${cy})`,
    stroke: stroke,
    strokeWidth: sw,
    fill: "var(--bg-canvas, #fff)"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M-22,4 L18,4 L26,-2 L-14,-2 Z",
    fill: "var(--bg-sunken)"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M-20,-2 L20,-2 L28,-8 L-12,-8 Z"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M-18,-8 L22,-8 L30,-14 L-10,-14 Z"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-12",
    y1: "-12",
    x2: "22",
    y2: "-12",
    stroke: stroke,
    strokeWidth: "0.8"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-10",
    y1: "-10",
    x2: "20",
    y2: "-10",
    stroke: stroke,
    strokeWidth: "0.8"
  }));
}
function IsoCallTower({
  cx,
  cy,
  stroke,
  sw
}) {
  return /*#__PURE__*/React.createElement("g", {
    transform: `translate(${cx} ${cy})`,
    stroke: stroke,
    strokeWidth: sw,
    fill: "none"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M-10,16 L-3,-30 L3,-30 L10,16 Z",
    fill: "var(--bg-canvas, #fff)"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-8",
    y1: "0",
    x2: "8",
    y2: "0"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-6",
    y1: "-12",
    x2: "6",
    y2: "-12"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-4",
    y1: "-22",
    x2: "4",
    y2: "-22"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M-18,-28 Q0,-44 18,-28"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M-12,-26 Q0,-36 12,-26"
  }));
}
function IsoMembership({
  cx,
  cy,
  stroke,
  sw
}) {
  return /*#__PURE__*/React.createElement("g", {
    transform: `translate(${cx} ${cy})`,
    stroke: stroke,
    strokeWidth: sw,
    fill: "var(--bg-canvas, #fff)"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M-22,-2 L14,-14 L26,-8 L-10,4 Z",
    fill: "var(--bg-sunken)"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-16",
    y1: "-1",
    x2: "-2",
    y2: "-6",
    stroke: stroke,
    strokeWidth: "0.8"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "-14",
    y1: "2",
    x2: "6",
    y2: "-6",
    stroke: stroke,
    strokeWidth: "0.8"
  }));
}
function IsoSilo({
  cx,
  cy,
  stroke,
  sw
}) {
  return /*#__PURE__*/React.createElement("g", {
    transform: `translate(${cx} ${cy})`,
    stroke: stroke,
    strokeWidth: sw,
    fill: "var(--bg-canvas, #fff)"
  }, /*#__PURE__*/React.createElement("ellipse", {
    cx: "0",
    cy: "-30",
    rx: "9",
    ry: "3"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M-9,-30 L-9,8 L9,8 L9,-30"
  }), /*#__PURE__*/React.createElement("ellipse", {
    cx: "0",
    cy: "8",
    rx: "9",
    ry: "3",
    fill: "var(--bg-sunken)"
  }));
}
function IsoCrate({
  cx,
  cy,
  stroke,
  sw
}) {
  return /*#__PURE__*/React.createElement("g", {
    transform: `translate(${cx} ${cy})`,
    stroke: stroke,
    strokeWidth: sw,
    fill: "var(--bg-canvas, #fff)"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M-12,4 L0,-2 L12,4 L0,10 Z"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M-12,4 L-12,-6 L0,-12 L0,-2 Z",
    fill: "var(--bg-sunken)"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M0,-2 L0,-12 L12,-6 L12,4 Z"
  }));
}
function IsoTree({
  cx,
  cy,
  stroke,
  sw
}) {
  return /*#__PURE__*/React.createElement("g", {
    transform: `translate(${cx} ${cy})`,
    stroke: stroke,
    strokeWidth: sw,
    fill: "var(--bg-canvas, #fff)"
  }, /*#__PURE__*/React.createElement("path", {
    d: "M0,-30 L-10,-6 L10,-6 Z"
  }), /*#__PURE__*/React.createElement("path", {
    d: "M0,-18 L-12,8 L12,8 Z"
  }), /*#__PURE__*/React.createElement("line", {
    x1: "0",
    y1: "8",
    x2: "0",
    y2: "14"
  }));
}
function InspectorCallout() {
  return /*#__PURE__*/React.createElement("div", {
    className: 'iiq-arch-inspector',
    style: {
      position: 'absolute',
      // sit under the JOB pill's area but to the LEFT of where any object draws
      // (objects start ~x=170 in our 1200-wide viewBox; this card lives in 0–14%)
      left: 16,
      top: 130,
      width: 210,
      background: 'var(--bg-canvas, #fff)',
      border: '1px solid var(--fg-primary)',
      borderRadius: 4,
      fontFamily: 'var(--font-mono)',
      fontSize: 10,
      color: 'var(--fg-primary)',
      boxShadow: '0 12px 28px -10px oklch(7.5% 0.003 286 / 0.18)',
      zIndex: 2
    }
  }, /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '8px 12px',
      borderBottom: '1px solid var(--border-default)',
      letterSpacing: '0.16em',
      textTransform: 'uppercase',
      fontSize: 10
    }
  }, "JOB OBJECT"), /*#__PURE__*/React.createElement("div", {
    style: {
      padding: '10px 12px',
      display: 'grid',
      gridTemplateColumns: '1fr auto',
      rowGap: 6,
      columnGap: 12
    }
  }, /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--fg-tertiary)'
    }
  }, "Status"), /*#__PURE__*/React.createElement("span", null, /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--ignite-500)'
    }
  }, "\u25CF "), "Dispatched"), /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--fg-tertiary)'
    }
  }, "Value"), /*#__PURE__*/React.createElement("span", null, "$1,840"), /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--fg-tertiary)'
    }
  }, "Technician"), /*#__PURE__*/React.createElement("span", null, "R. Alvarez"), /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--fg-tertiary)'
    }
  }, "ETA"), /*#__PURE__*/React.createElement("span", null, "14:22"), /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--fg-tertiary)'
    }
  }, "Margin"), /*#__PURE__*/React.createElement("span", null, "38.4%"), /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--fg-tertiary)'
    }
  }, "Callback risk"), /*#__PURE__*/React.createElement("span", null, "Low ", /*#__PURE__*/React.createElement("span", {
    style: {
      color: 'var(--ignite-500)'
    }
  }, "\u2198"))));
}
window.ArchOntologyScene = ArchOntologyScene;
})();
