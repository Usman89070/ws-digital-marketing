<?php
$caseStudies = require __DIR__ . '/case-study-data.php';

$slug = $_GET['slug'] ?? '';
$study = $caseStudies[$slug] ?? null;

if (!$study) {
    header('HTTP/1.0 404 Not Found');
    $page_title = 'Case Study Not Found';
    $page_description = 'This case study could not be found.';
    include 'header.php';
    ?>
    <section class="hero">
        <div class="container hero-content">
            <h1>Case Study Not Found</h1>
            <p class="hero-subtitle">This project may have been moved or renamed.</p>
            <div class="hero-buttons">
                <a href="/case-studies" class="btn-primary">Back To Case Studies</a>
            </div>
        </div>
    </section>
    <?php
    include 'footer.php';
    exit;
}

$page_title = $study['name'];
$page_description = $study['summary'];

// A small "More Case Studies" strip below the content -- next 3 entries in
// the data file after the current one (wrapping around), excluding itself.
$slugs = array_keys($caseStudies);
$currentIndex = array_search($slug, $slugs, true);
$moreSlugs = [];
for ($i = 1; count($moreSlugs) < 3 && $i < count($slugs); $i++) {
    $candidate = $slugs[($currentIndex + $i) % count($slugs)];
    if ($candidate !== $slug) {
        $moreSlugs[] = $candidate;
    }
}

include 'header.php';
?>

    <!-- CASE STUDY HERO -->
    <section class="hero" style="padding-bottom: clamp(30px, 6vw, 60px);">
        <div class="container hero-content">
            <span class="eyebrow fade-up"><?php echo htmlspecialchars($study['tag'], ENT_QUOTES, 'UTF-8'); ?></span>
            <h1 class="fade-up"><?php echo htmlspecialchars($study['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
        </div>
    </section>

    <!-- CASE STUDY CONTENT -->
    <section class="agency-section fade-up">
        <div class="container">
            <div class="agency-grid">
                <div class="agency-image-wrapper">
                    <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($study['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($study['image_alt'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="agency-text">
                    <span class="eyebrow">
                        <?php echo $study['has_data'] ? 'PROJECT RESULTS' : 'PROJECT SCOPE'; ?>
                        <?php if ($study['has_data']): ?><span style="color: var(--text-muted); font-weight: 600; text-transform: none; letter-spacing: normal;"> &middot; <?php echo htmlspecialchars($study['period'], ENT_QUOTES, 'UTF-8'); ?></span><?php endif; ?>
                    </span>
                    <h2><?php echo $study['has_data'] ? 'What We Delivered' : 'The Engagement'; ?></h2>
                    <p><?php echo htmlspecialchars($study['summary'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php if (!$study['has_data']): ?>
                    <p style="font-style: italic; color: var(--text-muted); font-size: 0.9rem;">Detailed performance results for this project will be published here soon.</p>
                    <?php endif; ?>
                    <ul class="agency-list" style="margin-top: 20px;">
                        <?php foreach ($study['services'] as $service): ?>
                        <li><i class="fa-solid fa-check"></i> <?php echo htmlspecialchars($service, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php if ($study['has_data']): ?>
    <!-- RESULTS AT A GLANCE -->
    <section class="stats-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow" style="color: var(--cyan-neon);">RESULTS AT A GLANCE</span>
                <h2 style="color: #fff; font-size: clamp(1.8rem, 4vw, 2.8rem);">Real Numbers, Verified From Search Console &amp; GBP</h2>
            </div>
            <div class="stats-4-grid">
                <?php foreach ($study['stats'] as [$value, $label]): ?>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
                    <h3><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- MORE CASE STUDIES -->
    <section class="services-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">MORE PROJECTS</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;">More Client Work</h2>
            </div>
            <div class="case-grid">
                <?php foreach ($moreSlugs as $moreSlug): $more = $caseStudies[$moreSlug]; ?>
                <article class="case-card">
                    <div class="case-image">
                        <span class="case-tag"><?php echo htmlspecialchars($more['tag'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($more['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($more['image_alt'], ENT_QUOTES, 'UTF-8'); ?>">
                        <h3><?php echo htmlspecialchars(strtoupper($more['name']), ENT_QUOTES, 'UTF-8'); ?></h3>
                    </div>
                    <div class="case-content">
                        <div>
                            <p><?php echo htmlspecialchars($more['summary'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <div>
                            <a href="/case-studies/<?php echo htmlspecialchars($moreSlug, ENT_QUOTES, 'UTF-8'); ?>" class="service-link">View Details <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: clamp(30px, 4vw, 40px);">
                <a href="/case-studies" class="service-link"><i class="fa-solid fa-arrow-left"></i> Back To All Case Studies</a>
            </div>
        </div>
    </section>

    <!-- FINAL CTA SECTION -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-box fade-up">
                <div class="cta-badge"><i class="fa-solid fa-rocket"></i> Let's Scale Together</div>
                <h2>Ready To Write Your Own Success Story?</h2>
                <p>Partner with W&S Digital Marketing to build a custom, data-driven growth plan that generates high-intent leads, consistent sales, and maximum ROAS.</p>
                <div class="cta-features">
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Zero Obligation Audit</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Custom Growth Strategy</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Proven Australian Results</span>
                </div>
                <div class="cta-btn-wrapper">
                    <a href="/contact" class="btn-primary" style="padding: 18px 45px; font-size: 1.1rem;">GET MY FREE GROWTH PLAN <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>
