<?php
// Served at /robots.txt (see the .htaccess rewrite). The content comes from
// admin -> SEO -> Robots.txt; until one has been saved there, the original
// default rules are served.
require_once __DIR__ . '/includes/seo.php';

header('Content-Type: text/plain; charset=UTF-8');
$custom = seo_setting('robots_txt');
echo ($custom !== null && trim($custom) !== '') ? rtrim($custom) . "\n" : seo_default_robots();
