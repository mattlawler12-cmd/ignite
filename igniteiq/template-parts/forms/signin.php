<?php
if (!defined('ABSPATH')) exit;
/**
 * Sign in — STATIC PLACEHOLDER (per user direction).
 *
 * Two-column layout matching the latest Claude Design export (SignIn.js):
 * dark sidebar on the left, light form column on the right. Form is
 * presentational/disabled — no auth target is wired yet.
 *
 * All visible copy is hardcoded to match the export byte-accurately. No ACF
 * fields back this template.
 */
?>
<!-- TODO: wire to real auth target when available. Currently a placeholder. -->
<section data-reveal class="iiq-pad" style="min-height:calc(100vh - 80px);background:var(--bg-canvas);">
  <div style="min-height:calc(100vh - 80px);display:grid;grid-template-columns:1fr 1fr;background:var(--bg-canvas);" class="iiq-grid-split">

    <aside style="background:var(--ink-1000);color:var(--ink-50, #fff);padding:64px 56px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden;">
      <div aria-hidden="true" style="position:absolute;top:-10%;right:-20%;width:70%;height:70%;background:radial-gradient(ellipse, rgba(239,68,68,0.18), transparent 60%);pointer-events:none;"></div>

      <a href="<?= esc_url(home_url('/')) ?>" style="display:inline-flex;align-items:center;gap:16px;text-decoration:none;color:var(--ink-50, #fff);position:relative;">
        <span style="font-family:'Aeonik Fono',monospace;font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.5);">&larr; Back to igniteiq.com</span>
      </a>

      <div style="position:relative;max-width:480px;">
        <div style="font-family:'Aeonik Fono',monospace;font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--ignite-400, #f87171);margin-bottom:24px;display:inline-flex;align-items:center;gap:8px;">
          <span style="width:6px;height:6px;border-radius:50%;background:var(--ignite-500);"></span>
          Customer access
        </div>
        <h1 style="font-family:'Aeonik',sans-serif;font-size:clamp(40px, 4.4vw, 64px);font-weight:600;letter-spacing:-0.04em;line-height:1.02;margin:0;color:var(--ink-50, #fff);">Welcome back.<span style="color:rgba(255,255,255,0.65);"> Your intelligence is waiting.</span></h1>
        <p style="margin-top:24px;font-size:16px;line-height:1.55;color:rgba(255,255,255,0.72);max-width:440px;">Sign in to your IgniteIQ workspace to query the ontology, monitor signals, and run agents across your business.</p>
      </div>

      <div style="position:relative;font-family:'Aeonik Fono',monospace;font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.5);">v4.2 &middot; running in your cloud</div>
    </aside>

    <main style="padding:48px 56px;display:flex;flex-direction:column;background:var(--bg-canvas);">
      <div style="display:flex;justify-content:flex-end;font-family:'Aeonik Fono',monospace;font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);">
        <span>New here?</span>
        <a href="<?= esc_url(home_url('/contact/')) ?>" style="margin-left:8px;color:var(--ignite-500);text-decoration:none;">Contact us</a>
      </div>

      <div style="flex:1;display:flex;align-items:center;justify-content:center;">
        <div style="width:100%;max-width:420px;">
          <h2 style="font-family:'Aeonik',sans-serif;font-size:36px;font-weight:600;letter-spacing:-0.03em;line-height:1.1;margin:0;color:var(--fg-primary);">Sign in</h2>
          <p style="margin-top:12px;font-size:15px;line-height:1.55;color:var(--fg-secondary);">Use your work email to access your workspace.</p>

          <form aria-disabled="true" onsubmit="event.preventDefault();" style="margin-top:40px;display:flex;flex-direction:column;gap:28px;">
            <div>
              <label class="iiq-field-label" for="iiq-signin-email" style="font-family:'Aeonik Fono',monospace;font-size:10px;letter-spacing:0.16em;text-transform:uppercase;color:var(--fg-tertiary);margin-bottom:8px;display:block;">Email</label>
              <input id="iiq-signin-email" name="email" type="email" autocomplete="email" placeholder="you@company.com" required
                style="width:100%;box-sizing:border-box;appearance:none;background:transparent;border:none;border-bottom:1px solid var(--border-default);padding:12px 0;font-size:16px;font-family:inherit;color:var(--fg-primary);outline:none;">
            </div>

            <div>
              <label class="iiq-field-label" for="iiq-signin-password" style="font-family:'Aeonik Fono',monospace;font-size:10px;letter-spacing:0.16em;text-transform:uppercase;color:var(--fg-tertiary);margin-bottom:8px;display:block;">Password</label>
              <input id="iiq-signin-password" name="password" type="password" autocomplete="current-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required
                style="width:100%;box-sizing:border-box;appearance:none;background:transparent;border:none;border-bottom:1px solid var(--border-default);padding:12px 0;font-size:16px;font-family:inherit;color:var(--fg-primary);outline:none;">
            </div>

            <button type="submit" disabled aria-disabled="true" title="Sign-in is not yet wired to an auth target."
              style="margin-top:8px;appearance:none;border:none;cursor:pointer;background:var(--ignite-500);color:var(--ink-50, #fff);font-family:'Aeonik',sans-serif;font-weight:500;font-size:16px;letter-spacing:-0.01em;padding:14px 24px;border-radius:4px;display:inline-flex;align-items:center;justify-content:center;gap:8px;width:100%;">
              Sign in <span style="font-size:14px;">&rarr;</span>
            </button>

            <div style="display:flex;justify-content:space-between;align-items:center;font-size:14px;color:var(--fg-secondary);">
              <a href="#" style="color:var(--fg-secondary);text-decoration:none;border-bottom:1px dotted var(--border-default);padding-bottom:1px;">Forgot email?</a>
              <a href="#" style="color:var(--fg-secondary);text-decoration:none;border-bottom:1px dotted var(--border-default);padding-bottom:1px;">Forgot password?</a>
            </div>
          </form>
        </div>
      </div>

      <div style="font-family:'Aeonik Fono',monospace;font-size:10px;letter-spacing:0.16em;text-transform:uppercase;color:var(--fg-tertiary);display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;">
        <span>&copy; 2025 IgniteIQ Inc.</span>
        <span style="display:flex;gap:20px;">
          <a href="#" style="color:var(--fg-tertiary);text-decoration:none;">Security</a>
          <a href="#" style="color:var(--fg-tertiary);text-decoration:none;">Privacy</a>
          <a href="#" style="color:var(--fg-tertiary);text-decoration:none;">Terms</a>
        </span>
      </div>
    </main>

  </div>
</section>
