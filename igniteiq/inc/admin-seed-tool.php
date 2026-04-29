<?php
/**
 * Admin migration + seed tool — temporary tool used to populate WP Engine
 * staging from the WP Admin UI when SSH/WP-CLI is not available.
 *
 * Adds: Tools → IgniteIQ Migrate
 *
 * REMOVE THIS FILE + the matching require_once in functions.php once staging
 * has been seeded and is no longer in flux.
 */

if (!defined('ABSPATH')) exit;

add_action('admin_menu', function () {
    add_management_page(
        'IgniteIQ Migrate',
        'IgniteIQ Migrate',
        'manage_options',
        'igniteiq-migrate',
        'iiq_admin_seed_tool_render'
    );
});

function iiq_admin_seed_tool_render() {
    if (!current_user_can('manage_options')) return;

    $messages = [];
    $errors   = [];

    if (isset($_POST['iiq_migrate_seed']) && check_admin_referer('iiq_migrate_seed', 'iiq_migrate_seed_nonce')) {
        $force = !empty($_POST['iiq_force_overwrite']);

        if (!class_exists('IgniteIQ_CLI')) {
            require_once IIQ_DIR . '/inc/cli.php';
        }
        if (!class_exists('IgniteIQ_CLI') || !method_exists('IgniteIQ_CLI', 'default_pages')) {
            $errors[] = 'IgniteIQ_CLI class is unavailable. Make sure inc/cli.php exists and defines IgniteIQ_CLI::default_pages().';
        } else if (!function_exists('update_field')) {
            $errors[] = 'ACF Pro is not active. Cannot write fields.';
        } else {
            $pages = IgniteIQ_CLI::default_pages();
            foreach ($pages as $slug => $rows) {
                $page_id = iiq_admin_seed_resolve_page($slug);
                if (!$page_id) {
                    $errors[] = "Could not resolve page for slug '{$slug}'.";
                    continue;
                }
                $existing = get_field('page_sections', $page_id);
                if (!empty($existing) && !$force) {
                    $messages[] = "Skipped '{$slug}' (id {$page_id}) — already has content. Tick \"Force overwrite\" to replace.";
                    continue;
                }
                update_field('page_sections', $rows, $page_id);
                $messages[] = "Seeded '{$slug}' (id {$page_id}) with " . count($rows) . ' sections.';
            }
        }
    }
    ?>
    <div class="wrap">
        <h1>IgniteIQ Migrate</h1>
        <p>Creates the six cornerstone pages if missing, sets <strong>Home</strong> as the front page, and seeds each page's <code>page_sections</code> from <code>inc/cli.php</code>.</p>
        <p><strong>Pages:</strong> home, how-it-works, ontology, company, contact, signin.</p>

        <?php foreach ($messages as $m): ?>
            <div class="notice notice-success"><p><?= esc_html($m) ?></p></div>
        <?php endforeach; ?>
        <?php foreach ($errors as $e): ?>
            <div class="notice notice-error"><p><?= esc_html($e) ?></p></div>
        <?php endforeach; ?>

        <form method="post" style="margin-top:24px;">
            <?php wp_nonce_field('iiq_migrate_seed', 'iiq_migrate_seed_nonce'); ?>
            <p>
                <label>
                    <input type="checkbox" name="iiq_force_overwrite" value="1">
                    <strong>Force overwrite</strong> — replace existing <code>page_sections</code> on every page (use this when applying updated seed content).
                </label>
            </p>
            <p>
                <button type="submit" name="iiq_migrate_seed" value="1" class="button button-primary button-large">Run migration + seed</button>
            </p>
        </form>

        <hr>
        <p style="color:#666;font-size:13px;">After staging is happy, delete <code>inc/admin-seed-tool.php</code> and remove the matching <code>require_once</code> block in <code>functions.php</code>.</p>
    </div>
    <?php
}

function iiq_admin_seed_resolve_page($slug) {
    if ($slug === 'home') {
        $front = (int) get_option('page_on_front');
        if ($front) return $front;
        $existing = get_page_by_path('home');
        if ($existing) return $existing->ID;
        $id = wp_insert_post([
            'post_title'  => 'Home',
            'post_name'   => 'home',
            'post_type'   => 'page',
            'post_status' => 'publish',
        ]);
        if (!is_wp_error($id)) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $id);
            return $id;
        }
        return 0;
    }

    $page = get_page_by_path($slug);
    if ($page) return $page->ID;

    $title = ucwords(str_replace('-', ' ', $slug));
    $id = wp_insert_post([
        'post_title'  => $title,
        'post_name'   => $slug,
        'post_type'   => 'page',
        'post_status' => 'publish',
    ]);
    return is_wp_error($id) ? 0 : $id;
}
