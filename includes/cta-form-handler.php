<?php
// Shared enquiry-form handler for every page's "Ready To...?" CTA section
// (includes/cta-form.php renders the matching form). Required at the very
// top of each page, before header.php, using the same header-injection-safe
// mail handling as contact.php's own form. Sets $cta_email_sent/$cta_form_error
// for the page (or includes/cta-form.php) to read.
$cta_email_sent = false;
$cta_form_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $cta_clean = function ($value) {
        $value = preg_replace('/[\r\n\x00-\x1F\x7F]/', '', (string) $value);
        return trim(strip_tags($value));
    };

    $cta_name    = $cta_clean($_POST['name'] ?? '');
    $cta_email   = filter_var($cta_clean($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $cta_phone   = $cta_clean($_POST['phone'] ?? '');
    $cta_service = $cta_clean($_POST['service'] ?? '');
    $cta_message = $cta_clean($_POST['message'] ?? '');

    if ($cta_name === '' || $cta_message === '' || !filter_var($cta_email, FILTER_VALIDATE_EMAIL)) {
        $cta_form_error = 'Please fill in your name, a valid email address, and your message.';
    } else {
        $cta_to = 'info@wsdigitalmarketing.com.au';
        $cta_subject = 'New Growth Plan Request from ' . $cta_name;
        $cta_page = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        $cta_body = "Name: $cta_name\n";
        $cta_body .= "Email: $cta_email\n";
        $cta_body .= "Phone: $cta_phone\n";
        $cta_body .= "Service Needed: $cta_service\n";
        $cta_body .= "Page: $cta_page\n";
        $cta_body .= "\nMessage:\n$cta_message\n";

        $cta_headers = "From: W&S Digital Marketing <info@wsdigitalmarketing.com.au>\r\n";
        $cta_headers .= "Reply-To: $cta_name <$cta_email>\r\n";
        $cta_headers .= 'X-Mailer: PHP/' . phpversion();

        if (mail($cta_to, $cta_subject, $cta_body, $cta_headers)) {
            $cta_email_sent = true;
        } else {
            $cta_form_error = 'Something went wrong sending your message. Please try again or email us directly at info@wsdigitalmarketing.com.au.';
        }
    }
}
