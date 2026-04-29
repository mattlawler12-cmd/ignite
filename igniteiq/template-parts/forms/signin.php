<?php
if (!defined('ABSPATH')) exit;
/**
 * Sign in — STATIC PLACEHOLDER (per user direction).
 *
 * Renders the styled form with a disabled submit button. No POST handler
 * exists; the form is presentational only until a real auth target is wired.
 */
?>
<!-- TODO: wire to real auth target when available. Currently a placeholder. -->
<section data-reveal class="iiq-pad" style="min-height:calc(100vh - 80px);padding:120px 32px;background:var(--bg-canvas);display:grid;place-items:center;">
  <div style="width:100%;max-width:440px;">
    <h1 class="iiq-display-md" style="font-family:'Aeonik',sans-serif;font-size:clamp(28px,4vw,40px);font-weight:600;letter-spacing:-0.02em;margin:0 0 12px;color:var(--fg-primary);">Sign in</h1>
    <p style="font-size:16px;color:var(--fg-secondary);margin:0 0 40px;line-height:1.5;">Access your IgniteIQ workspace.</p>

    <form aria-disabled="true" onsubmit="event.preventDefault();" style="display:flex;flex-direction:column;gap:24px;">
      <div>
        <label class="iiq-field-label" for="iiq-signin-email">Email</label>
        <input class="iiq-input" id="iiq-signin-email" name="email" type="email" autocomplete="email" placeholder="you@company.com" required>
      </div>
      <div>
        <label class="iiq-field-label" for="iiq-signin-password">Password</label>
        <input class="iiq-input" id="iiq-signin-password" name="password" type="password" autocomplete="current-password" placeholder="••••••••" required>
      </div>
      <div style="margin-top:16px;display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
        <button type="submit" class="iiq-btn" disabled aria-disabled="true" title="Sign-in is not yet wired to an auth target.">Sign in</button>
        <a href="#" style="font-size:13px;color:var(--fg-secondary);text-decoration:none;border-bottom:1px dotted var(--border-default);">Forgot password?</a>
      </div>
    </form>

    <p style="margin-top:48px;font-family:'Aeonik Fono',monospace;font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:var(--fg-tertiary);">v2 · placeholder</p>
  </div>
</section>
