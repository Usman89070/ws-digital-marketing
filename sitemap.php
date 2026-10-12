<?php
// Served at /sitemap.xml (see the .htaccess rewrite near the bottom of the
// rewrite block). Static pages are listed below; case study and blog post
// detail pages are pulled live from the database so a new one added through
// the admin panel appears here automatically, with no file to edit.
require_once __DIR__ . '/config.php';

header('Content-Type: application/xml; charset=UTF-8');

$base = 'https://wsdigitalmarketing.com.au';

$staticPages = [
    ['url' => '/', 'priority' => '1.0', 'freq' => 'weekly'],

    // Services
    ['url' => '/services', 'priority' => '0.9', 'freq' => 'monthly'],
    ['url' => '/seo', 'priority' => '0.9', 'freq' => 'monthly'],
    ['url' => '/ecommerce', 'priority' => '0.9', 'freq' => 'monthly'],
    ['url' => '/website-development', 'priority' => '0.9', 'freq' => 'monthly'],
    ['url' => '/social-media', 'priority' => '0.9', 'freq' => 'monthly'],
    ['url' => '/ppc-advertising', 'priority' => '0.9', 'freq' => 'monthly'],
    ['url' => '/graphic-design', 'priority' => '0.9', 'freq' => 'monthly'],
    ['url' => '/content-writing', 'priority' => '0.9', 'freq' => 'monthly'],

    // Industries
    ['url' => '/industries', 'priority' => '0.8', 'freq' => 'monthly'],
    ['url' => '/accounting-finance', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/automotive', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/construction-building', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/dental', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/ecommerce-industry', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/franchise', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/healthcare-medical', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/hospitality-tourism', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/hotel-motel', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/legal-law', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/real-estate', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/small-business-digital-marketing', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/ndis', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/trades', 'priority' => '0.7', 'freq' => 'monthly'],

    // Agency / proof
    ['url' => '/about', 'priority' => '0.6', 'freq' => 'monthly'],
    ['url' => '/our-team', 'priority' => '0.6', 'freq' => 'monthly'],
    ['url' => '/case-studies', 'priority' => '0.8', 'freq' => 'weekly'],
    ['url' => '/reviews', 'priority' => '0.6', 'freq' => 'monthly'],
    ['url' => '/pricing', 'priority' => '0.7', 'freq' => 'monthly'],
    ['url' => '/blog', 'priority' => '0.7', 'freq' => 'weekly'],
    ['url' => '/faq', 'priority' => '0.6', 'freq' => 'monthly'],
    ['url' => '/contact', 'priority' => '0.6', 'freq' => 'monthly'],

    // Legal
    ['url' => '/privacy-policy', 'priority' => '0.3', 'freq' => 'yearly'],
    ['url' => '/terms-of-service', 'priority' => '0.3', 'freq' => 'yearly'],
];

$caseStudies = [];
$blogPosts = [];
try {
    $caseStudies = get_db()->query('SELECT slug, updated_at FROM case_studies ORDER BY display_order ASC')->fetchAll();
    $blogPosts = get_db()->query('SELECT slug, updated_at FROM blog_posts WHERE is_published = 1 ORDER BY created_at DESC')->fetchAll();
} catch (PDOException $e) {
    $caseStudies = [];
    $blogPosts = [];
}

function sitemap_lastmod(?string $timestamp): string
{
    $time = $timestamp ? strtotime($timestamp) : false;
    return $time ? date('Y-m-d', $time) : date('Y-m-d');
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($staticPages as $page): ?>
    <url>
        <loc><?php echo htmlspecialchars($base . $page['url'], ENT_QUOTES, 'UTF-8'); ?></loc>
        <changefreq><?php echo $page['freq']; ?></changefreq>
        <priority><?php echo $page['priority']; ?></priority>
    </url>
<?php endforeach; ?>
<?php foreach ($caseStudies as $cs): ?>
    <url>
        <loc><?php echo htmlspecialchars($base . '/case-studies/' . $cs['slug'], ENT_QUOTES, 'UTF-8'); ?></loc>
        <lastmod><?php echo sitemap_lastmod($cs['updated_at'] ?? null); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
<?php endforeach; ?>
<?php foreach ($blogPosts as $post): ?>
    <url>
        <loc><?php echo htmlspecialchars($base . '/blog/' . $post['slug'], ENT_QUOTES, 'UTF-8'); ?></loc>
        <lastmod><?php echo sitemap_lastmod($post['updated_at'] ?? null); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
<?php endforeach; ?>
</urlset>
