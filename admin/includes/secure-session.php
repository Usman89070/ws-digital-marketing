<?php
// Starts the admin session with hardened cookie flags. Included instead of a
// bare session_start() from every admin entry point (login.php, logout.php,
// includes/auth.php) so the session cookie -- which is what proves someone is
// logged into the panel that can write to the database -- can never be read
// by JavaScript (XSS), sent over plain HTTP, or attached to a cross-site
// request.
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        // Only marked Secure when the request actually arrived over HTTPS,
        // so this can't silently lock out login before SSL is confirmed
        // working -- .htaccess already forces every request onto HTTPS.
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax',
    ]);
    session_start();
}
