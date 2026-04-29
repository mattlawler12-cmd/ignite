<?php
if (!defined('ABSPATH')) exit;

/**
 * Architecture Stack Diagram — IgniteIQ
 * Static port of ArchStackDiagram.jsx (484 lines).
 * Isometric four-platform stack: Intel / Signal / Agents on top,
 * Ontology in the middle, Data + Models + Actions on the bottom.
 * Pure SVG. All styling in IgniteIQ palette.
 */

$index          = get_sub_field('index')          ?: '03';
$label          = get_sub_field('label')          ?: 'The stack';
$header_label   = get_sub_field('header_label')   ?: 'How it all fits together';
$headline_left  = get_sub_field('headline_left')  ?: 'One model of your business.';
$headline_right = get_sub_field('headline_right') ?: 'Every product, every object, every system reads from it.';
$body           = get_sub_field('body')           ?: 'IgniteIQ deploys a data warehouse inside your cloud, unifies every operational system into a single ontology, and runs AI products on top of it. The whole stack is built to do one thing - make every decision your business makes sharper than the one before it.';
$closing_line   = get_sub_field('closing_line')   ?: '';

// ─── Palette ───────────────────────────────────────────────
$ink       = '#0F0F12';
$inkSoft   = '#5A5A60';
$line      = '#C9C5BD';
$lineSoft  = '#E2DDD2';
$cream     = '#FFFFFF';
$creamSide = '#F4EFE4';
$accent    = '#E11D2E';
$accentBg  = '#FBE0DD';

// ─── Helper: isometric platform ────────────────────────────
if (!function_exists('iiq_stack_platform')) {
    function iiq_stack_platform($cx, $cy, $w, $h, $line, $cream, $creamSide) {
        $depth = 14;
        $top = [
            [$cx,            $cy - $h / 2],
            [$cx + $w / 2,   $cy],
            [$cx,            $cy + $h / 2],
            [$cx - $w / 2,   $cy],
        ];
        $side = [
            [$cx - $w / 2,   $cy],
            [$cx,            $cy + $h / 2],
            [$cx + $w / 2,   $cy],
            [$cx + $w / 2,   $cy + $depth],
            [$cx,            $cy + $h / 2 + $depth],
            [$cx - $w / 2,   $cy + $depth],
        ];
        $topPts  = implode(' ', array_map(function($p){ return $p[0].','.$p[1]; }, $top));
        $sidePts = implode(' ', array_map(function($p){ return $p[0].','.$p[1]; }, $side));
        $rx = $w / 2 - 24;
        $shadowCy = $cy + $h / 2 + $depth + 12;
        echo '<g>';
        echo '<ellipse cx="'.$cx.'" cy="'.$shadowCy.'" rx="'.$rx.'" ry="5" fill="black" opacity="0.05" />';
        echo '<polygon points="'.$sidePts.'" fill="'.$creamSide.'" stroke="'.$line.'" strokeWidth="1" />';
        echo '<polygon points="'.$topPts.'" fill="'.$cream.'" stroke="'.$line.'" strokeWidth="1.25" />';
        echo '</g>';
    }
}

// ─── Helper: caption (above/below platform) ────────────────
if (!function_exists('iiq_stack_caption')) {
    function iiq_stack_caption($x, $y, $label, $sub, $tight, $ink, $inkSoft) {
        $size      = $tight ? 16 : 22;
        $tracking  = $tight ? '0.16em' : '0.22em';
        echo '<g>';
        echo '<text x="'.$x.'" y="'.$y.'" textAnchor="middle" fontFamily="var(--font-display), serif" fontSize="'.$size.'" fontWeight="700" fill="'.$ink.'" letterSpacing="'.$tracking.'">'.htmlspecialchars($label, ENT_QUOTES).'</text>';
        if ($sub) {
            echo '<text x="'.$x.'" y="'.($y + 18).'" textAnchor="middle" fontFamily="ui-monospace, \'SF Mono\', monospace" fontSize="10" fill="'.$inkSoft.'" letterSpacing="0.16em">'.htmlspecialchars($sub, ENT_QUOTES).'</text>';
        }
        echo '</g>';
    }
}

// ─── Helper: mini card ─────────────────────────────────────
if (!function_exists('iiq_stack_minicard')) {
    function iiq_stack_minicard($x, $y, $w, $h, $kind, $line, $ink, $inkSoft, $accent, $accentBg, $creamSide) {
        echo '<g>';
        echo '<rect x="'.($x + 2).'" y="'.($y + 2).'" width="'.$w.'" height="'.$h.'" rx="2" fill="black" opacity="0.04" />';
        echo '<rect x="'.$x.'" y="'.$y.'" width="'.$w.'" height="'.$h.'" rx="2" fill="white" stroke="'.$line.'" strokeWidth="1" />';
        echo '<rect x="'.$x.'" y="'.$y.'" width="'.$w.'" height="6" rx="2" fill="'.$creamSide.'" />';

        if ($kind === 'chart') {
            $pts = ($x + 6).','.($y + $h - 8).' '
                 . ($x + 14).','.($y + $h - 14).' '
                 . ($x + 22).','.($y + $h - 11).' '
                 . ($x + 30).','.($y + $h - 20).' '
                 . ($x + 38).','.($y + $h - 16).' '
                 . ($x + $w - 6).','.($y + $h - 24);
            echo '<polyline points="'.$pts.'" fill="none" stroke="'.$ink.'" strokeWidth="1.2" />';
            echo '<circle cx="'.($x + $w - 6).'" cy="'.($y + $h - 24).'" r="2.5" fill="'.$accent.'" />';
        }
        if ($kind === 'bars') {
            $bars = [10, 18, 14, 22, 16];
            foreach ($bars as $i => $bh) {
                $bx = $x + 6 + $i * 8;
                $by = $y + $h - $bh - 4;
                $fill = ($i === 3) ? $accent : $ink;
                $opacity = ($i === 3) ? 1 : 0.4;
                echo '<rect x="'.$bx.'" y="'.$by.'" width="5" height="'.$bh.'" fill="'.$fill.'" opacity="'.$opacity.'" />';
            }
        }
        if ($kind === 'alert') {
            echo '<g>';
            echo '<rect x="'.($x + 6).'" y="'.($y + 12).'" width="'.($w - 12).'" height="6" rx="1" fill="'.$accentBg.'" stroke="'.$accent.'" strokeWidth="0.6" />';
            echo '<rect x="'.($x + 6).'" y="'.($y + 22).'" width="'.(($w - 12) * 0.6).'" height="4" rx="1" fill="'.$ink.'" opacity="0.4" />';
            echo '<rect x="'.($x + 6).'" y="'.($y + 30).'" width="'.(($w - 12) * 0.4).'" height="4" rx="1" fill="'.$ink.'" opacity="0.25" />';
            echo '</g>';
        }
        if ($kind === 'agent') {
            echo '<g>';
            echo '<circle cx="'.($x + $w / 2).'" cy="'.($y + 18).'" r="6" stroke="'.$ink.'" fill="white" strokeWidth="0.9" />';
            echo '<rect x="'.($x + $w / 2 - 9).'" y="'.($y + 27).'" width="18" height="9" rx="1.5" fill="'.$accentBg.'" stroke="'.$accent.'" strokeWidth="0.6" />';
            echo '</g>';
        }
        if ($kind === 'data') {
            for ($i = 0; $i < 4; $i++) {
                $cy_ = $y + 12 + $i * 6;
                $rx_ = $w / 2 - 8;
                $fill = ($i === 1) ? $accentBg : 'white';
                echo '<ellipse cx="'.($x + $w / 2).'" cy="'.$cy_.'" rx="'.$rx_.'" ry="2.5" fill="'.$fill.'" stroke="'.$ink.'" strokeWidth="0.7" />';
            }
        }
        if ($kind === 'model') {
            echo '<g>';
            echo '<circle cx="'.($x + 12).'" cy="'.($y + 14).'" r="2.5" fill="'.$ink.'" />';
            echo '<circle cx="'.($x + 28).'" cy="'.($y + 14).'" r="2.5" fill="'.$ink.'" />';
            echo '<circle cx="'.($x + 20).'" cy="'.($y + 28).'" r="2.5" fill="'.$accent.'" />';
            echo '<circle cx="'.($x + 36).'" cy="'.($y + 28).'" r="2.5" fill="'.$ink.'" />';
            echo '<line x1="'.($x + 12).'" y1="'.($y + 14).'" x2="'.($x + 20).'" y2="'.($y + 28).'" stroke="'.$inkSoft.'" strokeWidth="0.6" />';
            echo '<line x1="'.($x + 28).'" y1="'.($y + 14).'" x2="'.($x + 20).'" y2="'.($y + 28).'" stroke="'.$inkSoft.'" strokeWidth="0.6" />';
            echo '<line x1="'.($x + 28).'" y1="'.($y + 14).'" x2="'.($x + 36).'" y2="'.($y + 28).'" stroke="'.$inkSoft.'" strokeWidth="0.6" />';
            echo '</g>';
        }
        echo '</g>';
    }
}

// ─── Helper: flow bundle ───────────────────────────────────
if (!function_exists('iiq_stack_flowbundle')) {
    function iiq_stack_flowbundle($fromX1, $fromX2, $fromY, $toX1, $toX2, $toY, $count, $hot, $arrowAtTop, $accent, $inkSoft) {
        $color   = $hot ? $accent : $inkSoft;
        $opacity = $hot ? 0.7 : 0.55;
        echo '<g>';
        // lines
        for ($i = 0; $i < $count; $i++) {
            $t  = $i / ($count - 1);
            $fx = $fromX1 + ($fromX2 - $fromX1) * $t;
            $tx = $toX1   + ($toX2   - $toX1)   * $t;
            $my = ($fromY + $toY) / 2;
            $d = "M $fx $fromY C $fx $my, $tx $my, $tx $toY";
            echo '<path d="'.$d.'" fill="none" stroke="'.$color.'" strokeWidth="0.7" strokeDasharray="1 3.5" opacity="'.$opacity.'" />';
        }
        // dots
        for ($i = 0; $i < $count; $i++) {
            $t  = $i / ($count - 1);
            $tx = $toX1 + ($toX2 - $toX1) * $t;
            echo '<circle cx="'.$tx.'" cy="'.$toY.'" r="1.4" fill="'.$color.'" opacity="'.($opacity + 0.1).'" />';
        }
        // arrows
        if ($arrowAtTop) {
            for ($i = 0; $i < $count; $i++) {
                if ($i % 2 !== 0) continue;
                $t  = $i / ($count - 1);
                $fx = $fromX1 + ($fromX2 - $fromX1) * $t;
                $d = "M ".($fx - 2.2)." ".($fromY + 3)." L $fx $fromY L ".($fx + 2.2)." ".($fromY + 3);
                echo '<path d="'.$d.'" fill="none" stroke="'.$color.'" strokeWidth="0.9" strokeLinecap="round" strokeLinejoin="round" opacity="'.($opacity + 0.2).'" />';
            }
        }
        echo '</g>';
    }
}
?>
<section data-reveal style="padding: 120px 32px 140px; background: var(--bg-canvas); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
  <div style="max-width: 1320px; margin: 0 auto;">

    <!-- section header -->
    <div data-reveal data-reveal-delay="0" style="display: flex; align-items: center; gap: 16px; font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--fg-tertiary);">
      <?php if ($index): ?><span><?= esc_html($index) ?></span><?php endif; ?>
      <span><?= esc_html($header_label) ?></span>
    </div>

    <h2 data-reveal data-reveal-delay="80" style="font-family: var(--font-display); font-size: clamp(40px, 5.6vw, 76px); font-weight: 600; letter-spacing: -0.04em; line-height: 0.98; margin: 20px 0 0; max-width: 1100px; color: var(--fg-primary);">
      <?= esc_html($headline_left) ?><span style="color: var(--fg-tertiary);"> <?= esc_html($headline_right) ?></span>
    </h2>
    <p data-reveal data-reveal-delay="160" style="margin-top: 28px; max-width: 760px; font-size: 19px; line-height: 1.55; color: var(--fg-secondary);"><?= esc_html($body) ?></p>

    <!-- ─── DIAGRAM ───────────────────────────────────────── -->
    <div data-reveal data-reveal-delay="240" class="iiq-scroll-x" style="margin-top: 80px; max-width: 1056px; margin-left: auto; margin-right: auto;">
      <svg viewBox="0 0 1280 960" width="100%" style="display: block; min-width: 720px;" xmlns="http://www.w3.org/2000/svg">

        <!-- ============ TOP CAPTIONS ============ -->
        <?php
        iiq_stack_caption(240,  50, 'ANALYTICS & BI',          'UNDERSTAND',           true, $ink, $inkSoft);
        iiq_stack_caption(640,  50, 'WORKFLOWS & AUTOMATIONS', 'ACTIONS',              true, $ink, $inkSoft);
        iiq_stack_caption(1040, 50, 'AGENTIC AGENTS & TOOLS',  'AGENTIC INTELLIGENCE', true, $ink, $inkSoft);
        ?>

        <!-- ============ TOP PLATFORMS ============ -->
        <?php
        iiq_stack_platform(240,  170, 300, 120, $line, $cream, $creamSide);
        iiq_stack_platform(640,  170, 300, 120, $line, $cream, $creamSide);
        iiq_stack_platform(1040, 170, 300, 120, $line, $cream, $creamSide);
        ?>

        <!-- mini cards -->
        <!-- INTEL — chart + bars -->
        <?php
        iiq_stack_minicard(170, 120, 68, 42, 'chart', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        iiq_stack_minicard(250, 130, 56, 32, 'bars',  $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        // SIGNAL — alert tiles
        iiq_stack_minicard(570, 120, 68, 42, 'alert', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        iiq_stack_minicard(650, 132, 60, 32, 'alert', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        // AGENTS — agent cards
        iiq_stack_minicard(970,  120, 56, 42, 'agent', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        iiq_stack_minicard(1036, 130, 56, 36, 'agent', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        ?>

        <!-- ============ TOP → MIDDLE FLOWS ============ -->
        <?php
        iiq_stack_flowbundle(150,  330,  210, 300, 460, 400, 14, false, false, $accent, $inkSoft);
        iiq_stack_flowbundle(550,  730,  210, 560, 720, 400, 14, false, false, $accent, $inkSoft);
        iiq_stack_flowbundle(950,  1130, 210, 820, 980, 400, 14, true,  false, $accent, $inkSoft);
        ?>

        <!-- relationship pills inside the flow -->

        <!-- ============ CENTRAL ONTOLOGY PLATFORM ============ -->
        <?php iiq_stack_platform(640, 460, 920, 180, $line, $cream, $creamSide); ?>

        <!-- JOB callout card (top-left of ontology) -->
        <g transform="translate(186, 380)">
          <rect x="0" y="0" width="170" height="70" rx="3" fill="white" stroke="<?= $ink ?>" strokeWidth="1" />
          <text x="12" y="18" fontFamily="ui-monospace, 'SF Mono', monospace" fontSize="10" fontWeight="700" fill="<?= $ink ?>" letterSpacing="0.08em">JOB Nº 4827</text>
          <line x1="12" y1="24" x2="158" y2="24" stroke="<?= $lineSoft ?>" />
          <?php
          $rows = [
              ['Tech',   'M. Reyes'],
              ['Region', 'Phoenix'],
              ['Margin', '$ 412'],
          ];
          foreach ($rows as $i => $kv) {
              [$k, $v] = $kv;
              $yk = 37 + $i * 12;
              echo '<g>';
              echo '<text x="12" y="'.$yk.'" fontFamily="ui-monospace, \'SF Mono\', monospace" fontSize="9" fill="'.$inkSoft.'">'.htmlspecialchars($k, ENT_QUOTES).'</text>';
              echo '<text x="158" y="'.$yk.'" textAnchor="end" fontFamily="ui-monospace, \'SF Mono\', monospace" fontSize="9" fontWeight="600" fill="'.$ink.'">'.htmlspecialchars($v, ENT_QUOTES).'</text>';
              echo '</g>';
          }
          ?>
          <!-- leader line into the lattice -->
          <line x1="170" y1="32" x2="244" y2="60" stroke="<?= $inkSoft ?>" strokeWidth="0.8" strokeDasharray="2 3" />
          <circle cx="244" cy="60" r="2" fill="<?= $accent ?>" />
        </g>

        <!-- ─── X / O LATTICE on the central platform ───
             Lattice fits inside the diamond top of the platform:
             cx=640, cy=460, w=920, h=180
             We mask glyphs to the diamond by only emitting points
             whose (|dx|/(w/2) + |dy|/(h/2)) <= 1, with a margin. -->
        <?php
        $cxL = 640; $cyL = 460; $wL = 920; $hL = 180;
        $halfW = $wL / 2; $halfH = $hL / 2;
        $margin = 0.08;
        $cols = 17;
        $rowsN = 7;
        $stepX = ($wL - 60) / ($cols - 1);
        $stepY = ($hL - 20) / ($rowsN - 1);
        $startX = $cxL - ($cols - 1) * $stepX / 2;
        $startY = $cyL - ($rowsN - 1) * $stepY / 2;

        $points = [];
        $grid   = [];
        $accentSet = ['1-5','2-9','3-12','4-6','4-13','2-3','5-8'];
        for ($r = 0; $r < $rowsN; $r++) {
            for ($c = 0; $c < $cols; $c++) {
                $px = $startX + $c * $stepX;
                $py = $startY + $r * $stepY;
                $dx = ($px - $cxL) / $halfW;
                $dy = ($py - $cyL) / $halfH;
                if (abs($dx) + abs($dy) > 1 - $margin) continue;
                $isX = (($r + $c) % 2 === 0);
                $isAccent = in_array("$r-$c", $accentSet, true);
                $p = ['r'=>$r,'c'=>$c,'px'=>$px,'py'=>$py,'isX'=>$isX,'isAccent'=>$isAccent];
                $points[] = $p;
                $grid["$r-$c"] = $p;
            }
        }

        $accentEdges = ['1-5_2-6','2-9_3-10','3-12_4-13','4-6_5-7','2-3_3-4','5-8_6-9'];
        $conns = [];
        foreach ($points as $p) {
            $neighbours = [
                [$p['r'],     $p['c'] + 1],
                [$p['r'] + 1, $p['c']],
                [$p['r'] + 1, $p['c'] + 1],
                [$p['r'] + 1, $p['c'] - 1],
            ];
            foreach ($neighbours as $nb) {
                [$nr, $nc] = $nb;
                if (!isset($grid["$nr-$nc"])) continue;
                $q = $grid["$nr-$nc"];
                $key1 = "{$p['r']}-{$p['c']}_{$nr}-{$nc}";
                $isAccentEdge = ($p['isAccent'] && $q['isAccent']) || in_array($key1, $accentEdges, true);
                $conns[] = [$p, $q, $isAccentEdge];
            }
        }
        ?>
        <g>
          <!-- connection lines — drawn first so glyphs sit on top -->
          <g fill="none">
            <?php foreach ($conns as $cn):
                [$a, $b, $hot] = $cn;
                $stroke   = $hot ? $accent : $inkSoft;
                $sOpacity = $hot ? 0.55 : 0.28;
                $sWidth   = $hot ? 0.7 : 0.55;
            ?>
            <line x1="<?= $a['px'] ?>" y1="<?= $a['py'] ?>" x2="<?= $b['px'] ?>" y2="<?= $b['py'] ?>" stroke="<?= $stroke ?>" strokeOpacity="<?= $sOpacity ?>" strokeWidth="<?= $sWidth ?>" strokeDasharray="0.8 2.4" />
            <?php endforeach; ?>
          </g>
          <!-- X / O glyphs — small -->
          <?php foreach ($points as $p):
              $color = $p['isAccent'] ? $accent : $ink;
              $size = 3;
              if ($p['isX']):
          ?>
          <g stroke="<?= $color ?>" strokeWidth="1" strokeLinecap="round">
            <line x1="<?= $p['px'] - $size ?>" y1="<?= $p['py'] - $size ?>" x2="<?= $p['px'] + $size ?>" y2="<?= $p['py'] + $size ?>" />
            <line x1="<?= $p['px'] - $size ?>" y1="<?= $p['py'] + $size ?>" x2="<?= $p['px'] + $size ?>" y2="<?= $p['py'] - $size ?>" />
          </g>
          <?php else: ?>
          <circle cx="<?= $p['px'] ?>" cy="<?= $p['py'] ?>" r="<?= $size ?>" fill="white" stroke="<?= $color ?>" strokeWidth="1" />
          <?php endif; endforeach; ?>
        </g>

        <!-- ============ ONTOLOGY caption (below platform) ============ -->
        <text x="640" y="632" textAnchor="middle" fontFamily="var(--font-display)" fontSize="34" fontWeight="800" fill="<?= $ink ?>" letterSpacing="0.30em">ONTOLOGY</text>
        <text x="640" y="656" textAnchor="middle" fontFamily="var(--font-mono)" fontSize="11" fill="<?= $inkSoft ?>" letterSpacing="0.14em">
          THE NOUNS, VERBS, AND DATA RELATIONSHIPS OF HOW YOUR BUSINESS ACTUALLY RUNS
        </text>

        <!-- ============ MIDDLE → BOTTOM FLOWS ============ -->
        <?php
        iiq_stack_flowbundle(300, 460,  540, 150,  330,  760, 14, false, true, $accent, $inkSoft);
        iiq_stack_flowbundle(560, 720,  540, 550,  730,  760, 14, false, true, $accent, $inkSoft);
        iiq_stack_flowbundle(820, 980,  540, 950,  1130, 760, 14, true,  true, $accent, $inkSoft);
        ?>

        <!-- ============ BOTTOM PLATFORMS ============ -->
        <?php
        iiq_stack_platform(240,  780, 300, 120, $line, $cream, $creamSide);
        iiq_stack_platform(640,  780, 300, 120, $line, $cream, $creamSide);
        iiq_stack_platform(1040, 780, 300, 120, $line, $cream, $creamSide);
        ?>

        <!-- mini cards on bottom platforms -->
        <!-- DATA — stacked drum cards -->
        <?php
        iiq_stack_minicard(170, 732, 68, 42, 'data', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        iiq_stack_minicard(250, 744, 56, 32, 'data', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        // MODELS & LOGIC — graph cards
        iiq_stack_minicard(570, 732, 68, 42, 'model', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        iiq_stack_minicard(650, 744, 60, 32, 'model', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        // ACTIONS — agent / writeback cards
        iiq_stack_minicard(970,  732, 56, 42, 'agent', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        iiq_stack_minicard(1036, 744, 56, 36, 'agent', $line, $ink, $inkSoft, $accent, $accentBg, $creamSide);
        ?>

        <!-- ============ BOTTOM CAPTIONS ============ -->
        <?php
        iiq_stack_caption(240,  905, 'DATA',           'FSM · OPS · FINANCE',              true, $ink, $inkSoft);
        iiq_stack_caption(640,  905, 'MODELS & LOGIC', 'SCORING · RESOLUTION · FORECAST',  true, $ink, $inkSoft);
        iiq_stack_caption(1040, 905, 'ACTIONS',        'WRITE-BACK · DISPATCH · NOTIFY',   true, $ink, $inkSoft);
        ?>

      </svg>
    </div>

    <!-- ─── Hero statement ─────────────────────────────── -->
    <div data-reveal data-reveal-delay="320" style="margin-top: 48px; padding-top: 56px; padding-bottom: 24px; border-top: 1px solid var(--border-subtle); display: flex; flex-direction: column; align-items: center; text-align: center;">
      <div style="font-family: var(--font-mono); font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--fg-tertiary); margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
        <span style="width: 24px; height: 1px; background: var(--border-default);"></span>
        <span><?= esc_html($label) ?></span>
        <span style="width: 24px; height: 1px; background: var(--border-default);"></span>
      </div>
      <h3 style="margin: 0; max-width: 880px; font-family: var(--font-display); font-size: clamp(28px, 3.4vw, 44px); line-height: 1.2; letter-spacing: -0.02em; font-weight: 400; color: var(--fg-primary); text-wrap: balance;">
        <?php if ($closing_line): ?>
          <?= wp_kses_post($closing_line) ?>
        <?php else: ?>
          Every decision&nbsp;&mdash;
          <em style="font-style: italic; color: var(--fg-tertiary);">faster, smarter, and right.</em>
        <?php endif; ?>
      </h3>
    </div>
  </div>
</section>
