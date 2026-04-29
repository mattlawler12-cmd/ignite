<?php
if (!defined('ABSPATH')) exit;

/**
 * Hero: Ontology
 *
 * Dedicated hero for the /ontology page. Renders an H1 composed of inline
 * segments that alternate between primary and tertiary (muted) foreground
 * colors, plus a divider-topped lede block. Mirrors OntologyHero in
 * exports/latest/js/Ontology.js (lines 4-58).
 *
 * Subfields:
 *   - eyebrow            (text)            e.g. "● The ontology · v4.2"
 *   - headline_segments  (repeater)        each row: { text (string), muted (bool) }
 *   - lede               (textarea/wysiwyg) full lede paragraph
 */

$eyebrow  = get_sub_field('eyebrow') ?: '';
$segments = get_sub_field('headline_segments') ?: [];
$lede     = get_sub_field('lede') ?: '';

// Fallback default headline segments (verbatim from OntologyHero export).
if (empty($segments)) {
    $segments = [
        ['text' => 'Ontology is the',       'muted' => false],
        ['text' => ' nouns and verbs ',     'muted' => true],
        ['text' => 'of how your business',  'muted' => false],
        ['text' => ' actually runs.',       'muted' => true],
    ];
}
?>
<section style="padding: 168px 32px 140px; background: var(--bg-base, var(--bg-canvas)); border-bottom: 1px solid var(--border-default);">
  <div style="max-width: 1320px; margin: 0 auto;">
    <?php if ($eyebrow): ?>
      <div style="font-family: var(--font-mono, 'Aeonik Fono', monospace); font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--ignite-500);">
        <?= esc_html($eyebrow) ?>
      </div>
    <?php endif; ?>

    <h1 style="font-family: var(--font-display); font-size: clamp(56px, 7.6vw, 132px); font-weight: 600; letter-spacing: -0.05em; line-height: 0.92; margin: 32px 0 0; color: var(--fg-primary); max-width: 1240px;">
      <?php foreach ($segments as $seg):
        $text  = is_array($seg) ? ($seg['text'] ?? '') : (string) $seg;
        $muted = is_array($seg) ? !empty($seg['muted']) : false;
        if ($text === '') continue;
      ?>
        <span style="color: <?= $muted ? 'var(--fg-tertiary)' : 'var(--fg-primary)' ?>;"><?= esc_html($text) ?></span>
      <?php endforeach; ?>
    </h1>

    <?php if ($lede): ?>
      <div style="margin-top: 56px; padding-top: 40px; border-top: 1px solid var(--border-default); max-width: 1100px;">
        <p style="font-size: 21px; line-height: 1.55; color: var(--fg-primary); margin: 0; font-weight: 500;">
          <?= wp_kses_post($lede) ?>
        </p>
      </div>
    <?php endif; ?>
  </div>
</section>
