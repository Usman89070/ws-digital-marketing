<?php
// Called automatically by deploy.yml right after every FTP upload (and can
// also be opened manually in a browser if the admin panel still looks
// stale after a deploy). Clears this server's PHP opcode cache so changed
// files are recompiled immediately, instead of whenever opcache would
// otherwise have gotten around to noticing the change.
require_once __DIR__ . '/config.php';

header('Content-Type: text/plain');

$token = $_GET['token'] ?? '';
$placeholder = 'change-this-to-a-long-random-string';
if (!defined('CACHE_RESET_TOKEN') || CACHE_RESET_TOKEN === $placeholder) {
    http_response_code(503);
    echo "CACHE_RESET_TOKEN is not configured in config.php yet -- see config.sample.php for setup.";
    exit;
}
if (!hash_equals(CACHE_RESET_TOKEN, $token)) {
    http_response_code(403);
    echo 'Forbidden';
    exit;
}

if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "opcache_reset() ran successfully.";
} else {
    echo "opcache_reset() is not available on this server (opcache may not be installed/enabled) -- nothing to clear.";
}
