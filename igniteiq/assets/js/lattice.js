/* IgniteIQ ambient lattice canvas — slow drifting nodes & relationships.
 * Targets every <canvas data-iiq-lattice> on the page.
 * Honors prefers-reduced-motion (single static frame, no rAF loop). */
(function () {
  'use strict';

  function init(canvas, opts) {
    var intensity = (opts && opts.intensity) || 1;
    var ctx = canvas.getContext('2d');
    if (!ctx) return;

    var raf, w, h, dpr;
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function size() {
      dpr = Math.min(2, window.devicePixelRatio || 1);
      var parent = canvas.parentElement;
      if (!parent) return;
      var r = parent.getBoundingClientRect();
      w = r.width;
      h = r.height;
      canvas.width = w * dpr;
      canvas.height = h * dpr;
      canvas.style.width = w + 'px';
      canvas.style.height = h + 'px';
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    }
    size();

    var ro;
    if (typeof ResizeObserver !== 'undefined' && canvas.parentElement) {
      ro = new ResizeObserver(size);
      ro.observe(canvas.parentElement);
    }

    var N = Math.round(46 * intensity);
    var nodes = [];
    for (var i = 0; i < N; i++) {
      nodes.push({
        x: Math.random() * w,
        y: Math.random() * h,
        vx: (Math.random() - 0.5) * 0.18,
        vy: (Math.random() - 0.5) * 0.18,
        r: Math.random() < 0.08 ? 2.4 : 1.1,
        glow: Math.random() < 0.10,
        seed: Math.random() * Math.PI * 2
      });
    }

    var t = 0;
    function frame() {
      t += 1;
      ctx.clearRect(0, 0, w, h);

      // Connections (only near pairs)
      var maxDist = Math.min(180, Math.max(120, Math.min(w, h) * 0.18));
      for (var i = 0; i < nodes.length; i++) {
        var a = nodes[i];
        for (var j = i + 1; j < nodes.length; j++) {
          var b = nodes[j];
          var dx = a.x - b.x, dy = a.y - b.y;
          var d = Math.sqrt(dx * dx + dy * dy);
          if (d < maxDist) {
            var alpha = (1 - d / maxDist) * 0.55;
            ctx.beginPath();
            ctx.moveTo(a.x, a.y);
            ctx.lineTo(b.x, b.y);
            ctx.strokeStyle = 'rgba(255,255,255,' + (alpha * 0.28) + ')';
            ctx.lineWidth = 0.6;
            ctx.stroke();
          }
        }
      }

      // Nodes
      for (var k = 0; k < nodes.length; k++) {
        var n = nodes[k];
        if (!reduce) { n.x += n.vx; n.y += n.vy; }
        if (n.x < -10) n.x = w + 10;
        if (n.x > w + 10) n.x = -10;
        if (n.y < -10) n.y = h + 10;
        if (n.y > h + 10) n.y = -10;
        var pulse = 0.6 + Math.sin(t * 0.018 + n.seed) * 0.4;
        if (n.glow) {
          var g = ctx.createRadialGradient(n.x, n.y, 0, n.x, n.y, 14);
          g.addColorStop(0, 'oklch(57.5% 0.232 25 / ' + (0.5 * pulse) + ')');
          g.addColorStop(1, 'oklch(57.5% 0.232 25 / 0)');
          ctx.fillStyle = g;
          ctx.beginPath();
          ctx.arc(n.x, n.y, 14, 0, Math.PI * 2);
          ctx.fill();
          ctx.fillStyle = 'oklch(65% 0.21 25 / ' + (0.85 * pulse) + ')';
          ctx.beginPath();
          ctx.arc(n.x, n.y, n.r + 0.6, 0, Math.PI * 2);
          ctx.fill();
        } else {
          ctx.fillStyle = 'rgba(255,255,255,' + (0.45 * pulse) + ')';
          ctx.beginPath();
          ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
          ctx.fill();
        }
      }

      if (!reduce) {
        raf = requestAnimationFrame(frame);
      }
    }

    if (reduce) {
      // Single static frame
      frame();
    } else {
      frame();
    }
  }

  function boot() {
    var canvases = document.querySelectorAll('canvas[data-iiq-lattice]');
    for (var i = 0; i < canvases.length; i++) {
      var c = canvases[i];
      var intensity = parseFloat(c.getAttribute('data-intensity'));
      init(c, { intensity: isNaN(intensity) ? 1 : intensity });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
