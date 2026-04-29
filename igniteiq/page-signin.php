<?php
/** Template Name: Sign in */
if (!defined('ABSPATH')) exit;
get_header();
?>
<style>
  /* Sign-in split-screen — collapses to single column on small viewports */
  .iiq-signin-grid { display:grid; grid-template-columns:1fr 1fr; min-height:calc(100vh - 70px); background:var(--bg-canvas,#fff); }
  .iiq-signin-grid > aside, .iiq-signin-grid > main { min-height:100%; }
  .iiq-signin-aside { position:relative; background:var(--ink-1000,#0F0F12); color:var(--ink-50,#FAFAFA); padding:64px 56px; display:flex; flex-direction:column; justify-content:space-between; overflow:hidden; }
  .iiq-signin-main  { padding:48px 56px; display:flex; flex-direction:column; position:relative; }
  .iiq-signin-form-wrap { width:100%; max-width:420px; flex:1; display:flex; align-items:center; }
  .iiq-signin-form { width:100%; display:flex; flex-direction:column; gap:28px; }
  .iiq-signin-field-label { display:block; font-family:var(--font-mono); font-size:10px; letter-spacing:0.16em; text-transform:uppercase; color:var(--fg-tertiary); margin-bottom:8px; }
  .iiq-signin-input { width:100%; border:none; border-bottom:1px solid var(--border-default,#C9C5BD); padding:12px 0; background:transparent; font-size:16px; color:var(--fg-primary); appearance:none; outline:none; transition:border-color 120ms ease; font-family:inherit; }
  .iiq-signin-input:focus { border-bottom-color:var(--ignite-500,#E11D2E); }
  .iiq-signin-input::placeholder { color:var(--fg-tertiary,#71717A); }
  .iiq-signin-submit { width:100%; background:var(--ignite-500,#E11D2E); color:#fff; padding:14px 24px; border-radius:4px; font-size:16px; font-family:var(--font-display); font-weight:500; border:none; cursor:not-allowed; opacity:0.9; }
  @media (max-width: 860px) {
    .iiq-signin-grid { grid-template-columns:1fr; }
    .iiq-signin-aside { padding:48px 32px; min-height:auto; }
    .iiq-signin-main { padding:48px 32px; }
  }
</style>
<div class="iiq-signin-grid">
  <aside class="iiq-signin-aside" aria-label="IgniteIQ sign-in details">
    <div aria-hidden="true" style="position:absolute;top:-10%;right:-20%;width:70%;height:70%;background:radial-gradient(ellipse, oklch(57.5% 0.232 25 / 0.18), transparent 60%);pointer-events:none;"></div>
    <div style="position:relative;">
      <a href="<?= esc_url(home_url('/')) ?>" style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:oklch(70% 0.005 286);text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
        &larr; Back to igniteiq.com
      </a>
    </div>
    <div style="position:relative;display:flex;flex-direction:column;gap:24px;">
      <span style="font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--ignite-400,#FCA5A5);">&#9679; Customer access</span>
      <h1 style="font-family:var(--font-display);font-size:clamp(40px,4.4vw,64px);font-weight:600;letter-spacing:-0.04em;line-height:0.98;margin:0;color:var(--ink-50,#FAFAFA);">
        Welcome back.<br>
        <span style="color:oklch(70% 0.005 286);">Your intelligence is waiting.</span>
      </h1>
      <p style="font-size:16px;line-height:1.55;color:oklch(78% 0.005 286);max-width:440px;margin:0;">
        Sign in to your IgniteIQ workspace to query the ontology, monitor signals, and run agents across your business.
      </p>
    </div>
    <div style="position:relative;font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:oklch(50% 0.005 286);">
      v4.2 &middot; running in your cloud
    </div>
  </aside>
  <main class="iiq-signin-main">
    <div style="display:flex;justify-content:flex-end;font-family:var(--font-mono);font-size:11px;letter-spacing:0.18em;text-transform:uppercase;color:var(--fg-tertiary);">
      <span>New here? <a href="<?= esc_url(home_url('/contact/')) ?>" style="color:var(--ignite-500);text-decoration:none;border-bottom:1px solid currentColor;">Contact us</a></span>
    </div>
    <div class="iiq-signin-form-wrap">
      <div style="width:100%;">
        <h2 style="font-family:var(--font-display);font-size:36px;font-weight:600;letter-spacing:-0.03em;line-height:1.1;margin:0 0 8px;color:var(--fg-primary);">Sign in</h2>
        <p style="font-size:15px;line-height:1.55;color:var(--fg-secondary,#5A5A60);margin:0 0 40px;">Use your work email to access your workspace.</p>
        <!-- TODO: wire to real auth target when available. Currently presentational placeholder. -->
        <form class="iiq-signin-form" aria-disabled="true" onsubmit="event.preventDefault();" novalidate>
          <div>
            <label class="iiq-signin-field-label" for="iiq-signin-email">Email</label>
            <input class="iiq-signin-input" id="iiq-signin-email" name="email" type="email" autocomplete="email" placeholder="you@company.com" autofocus>
          </div>
          <div>
            <label class="iiq-signin-field-label" for="iiq-signin-password">Password</label>
            <input class="iiq-signin-input" id="iiq-signin-password" name="password" type="password" autocomplete="current-password" placeholder="••••••••">
          </div>
          <button type="submit" class="iiq-signin-submit" disabled aria-disabled="true" title="Sign-in is not yet wired to an auth target.">Sign in &rarr;</button>
          <div style="display:flex;justify-content:space-between;gap:16px;font-size:13px;color:var(--fg-secondary,#5A5A60);">
            <a href="#" style="color:inherit;text-decoration:none;border-bottom:1px dotted var(--border-default);">Forgot email?</a>
            <a href="#" style="color:inherit;text-decoration:none;border-bottom:1px dotted var(--border-default);">Forgot password?</a>
          </div>
        </form>
      </div>
    </div>
    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;font-family:var(--font-mono);font-size:11px;letter-spacing:0.14em;text-transform:uppercase;color:var(--fg-tertiary);margin-top:48px;">
      <span>&copy; <?= esc_html(date('Y')) ?> IgniteIQ Inc.</span>
      <span style="display:inline-flex;gap:18px;">
        <a href="#" style="color:inherit;text-decoration:none;">Security</a>
        <a href="#" style="color:inherit;text-decoration:none;">Privacy</a>
        <a href="#" style="color:inherit;text-decoration:none;">Terms</a>
      </span>
    </div>
  </main>
</div>
<?php wp_footer(); ?>
</body>
</html>
