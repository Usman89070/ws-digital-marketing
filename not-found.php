<?php
// Handles every URL the web server couldn't match to a file or route (wired
// up in .htaccess with "ErrorDocument 404 /not-found.php"). In order:
//   1. an active redirect from admin -> SEO -> Redirects, if one matches;
//   2. otherwise the hit is logged for admin -> SEO -> 404 Errors;
//   3. then what the visitor sees follows the "Unmatched 404" setting in
//      admin -> SEO -> Site Settings: the original behaviour (send them to the
//      homepage) or a real 404 page.
require_once __DIR__ . '/includes/seo.php';

$requested = (string) ($_SERVER['REQUEST_URI'] ?? '/');
$path = seo_normalize_path($requested);
$requestedDirectly = ($_SERVER['REDIRECT_STATUS'] ?? '') !== '404';

if (!$requestedDirectly) {
    seo_try_redirect($path);
    seo_log_404($path);

    $isAsset = (bool) preg_match('/\.(?:jpe?g|png|gif|webp|avif|svg|ico|css|js|map|woff2?|ttf|eot|mp4|webm|pdf|xml|txt)$/i', $path);
    if (!$isAsset && seo_setting('unmatched_404', 'redirect_home') !== 'show_404') {
        header('Location: ' . SEO_SITE_BASE . '/', true, 302);
        exit;
    }
    if ($isAsset) {
        http_response_code(404);
        header('Content-Type: text/plain; charset=UTF-8');
        echo 'Not found';
        exit;
    }
}

http_response_code(404);
$seo_skip_redirect = true;
$page_title = 'Page Not Found';
$page_description = 'The page you were looking for could not be found.';
$extra_head = '    <meta name="robots" content="noindex, follow">' . "\n";
include __DIR__ . '/header.php';
?>
    <section class="hero">
        <div class="container hero-content">
            <h1>Page Not Found</h1>
            <p class="hero-subtitle">The page you were looking for may have been moved or no longer exists.</p>
            <div class="hero-buttons">
                <a href="/" class="btn-primary">Back To Homepage</a>
                <a href="/services" class="btn-secondary">View Our Services</a>
            </div>
        </div>
    </section>
<?php include __DIR__ . '/footer.php'; ?>
