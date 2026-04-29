<?php
/**
 * Contact form admin-ajax handler.
 *
 * Accepts POSTs from /assets/js/contact-form.js, validates nonce + honeypot
 * + minimum render-to-submit interval, sanitizes fields, sends via wp_mail().
 */
if (!defined('ABSPATH')) exit;

const IIQ_CONTACT_TOPICS = [
    'I want a demo',
    'Evaluating vs another platform',
    'Partnership',
    'Press',
    'Other',
];

const IIQ_CONTACT_MIN_DWELL_SECONDS = 3;

add_action('wp_ajax_iiq_contact', 'iiq_contact_handle');
add_action('wp_ajax_nopriv_iiq_contact', 'iiq_contact_handle');

function iiq_contact_handle() {
    if (!check_ajax_referer('iiq_contact', 'nonce', false)) {
        wp_send_json_error(['message' => 'Invalid request. Refresh and try again.'], 400);
    }

    // Honeypot — must be empty
    if (!empty($_POST['website'] ?? '')) {
        wp_send_json_success(['message' => 'Thanks — we received your note.']); // silently accept
        return;
    }

    // Time-trap — at least N seconds since the form was rendered
    $rendered_at = (int) ($_POST['rendered_at'] ?? 0);
    if ($rendered_at > 0 && (time() - $rendered_at) < IIQ_CONTACT_MIN_DWELL_SECONDS) {
        wp_send_json_success(['message' => 'Thanks — we received your note.']); // silently accept
        return;
    }

    $first   = sanitize_text_field($_POST['first']   ?? '');
    $last    = sanitize_text_field($_POST['last']    ?? '');
    $email   = sanitize_email($_POST['email']        ?? '');
    $company = sanitize_text_field($_POST['company'] ?? '');
    $role    = sanitize_text_field($_POST['role']    ?? '');
    $topic   = sanitize_text_field($_POST['topic']   ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    $errors = [];
    if ($first === '')                     $errors[] = 'First name is required.';
    if ($last === '')                      $errors[] = 'Last name is required.';
    if (!is_email($email))                 $errors[] = 'A valid email is required.';
    if ($company === '')                   $errors[] = 'Company is required.';
    if ($topic !== '' && !in_array($topic, IIQ_CONTACT_TOPICS, true)) {
        $errors[] = 'Invalid topic selection.';
    }

    if ($errors) {
        wp_send_json_error(['message' => implode(' ', $errors)], 422);
    }

    $to = function_exists('iiq_setting') ? iiq_setting('contact_email', get_option('admin_email')) : get_option('admin_email');
    $subject = sprintf('[IgniteIQ] New contact: %s %s — %s', $first, $last, $company);
    $body  = "Name: {$first} {$last}\n";
    $body .= "Email: {$email}\n";
    $body .= "Company: {$company}\n";
    $body .= "Role: {$role}\n";
    $body .= "Topic: {$topic}\n\n";
    $body .= "Message:\n{$message}\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $email,
    ];

    $sent = wp_mail($to, $subject, $body, $headers);

    if (!$sent) {
        wp_send_json_error(['message' => 'We hit a problem sending the message. Please email us directly.'], 500);
    }

    wp_send_json_success(['message' => 'Thanks — we got your note and will be in touch shortly.']);
}
