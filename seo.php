<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/case-study-helpers.php';

$seoCaseStudies = [];
$seoStats = [];
try {
    // Shown below as real client work, and as the source for the stats
    // section: every case study with real "Results At A Glance" data (these
    // are all local-SEO campaigns), PLUS any case study explicitly tagged
    // "SEO" (alone or combined with other services) even before it has real
    // stats yet. Pulled live from the same table the Case Studies admin
    // section manages: adding/editing a client's stats or tag from the
    // dashboard updates this page automatically.
    $rows = get_db()->query("SELECT slug, name, tag, image_path, image_alt, summary, stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label, has_data FROM case_studies ORDER BY display_order ASC")->fetchAll();
    foreach ($rows as $row) {
        if (!$row['has_data'] && !case_study_tag_has($row['tag'], 'seo')) {
            continue;
        }
        $seoCaseStudies[] = $row;
        foreach ([1, 2, 3, 4] as $n) {
            $value = $row["stat{$n}_value"];
            $label = $row["stat{$n}_label"];
            if ($value === '' && $label === '') {
                continue;
            }
            $seoStats[] = [$value, $label];
        }
    }
    // Stats sharing the same label (e.g. multiple businesses' "Organic
    // Clicks") are combined into one box instead of shown per-business.
    $seoStats = combine_stats($seoStats);
} catch (PDOException $e) {
    $seoCaseStudies = [];
    $seoStats = [];
}

$page_title = 'Search Engine Optimization';
$page_description = 'Local SEO, technical audits, and content strategies engineered to get your business found on Google and Google Maps.';
include 'header.php';
?>

    <!-- SEO HERO SECTION -->
    <section class="hero" style="padding-bottom: clamp(40px, 8vw, 80px);">
        <div class="container hero-content">
            <span class="eyebrow fade-up">SEARCH ENGINE OPTIMIZATION</span>
            <h1 class="fade-up">RANK HIGHER. GET FOUND. <br><span class="text-gradient">GROW ORGANICALLY.</span></h1>
            <p class="hero-subtitle fade-up">We combine technical SEO, local search optimization, and content strategy to get your business in front of customers who are already searching for what you offer.</p>
            <div class="hero-buttons fade-up">
                <a href="/contact" class="btn-primary">GET MY FREE SEO AUDIT <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                <a href="/services" class="btn-secondary">VIEW ALL SERVICES</a>
            </div>
        </div>
    </section>

    <!-- INTRO SECTION -->
    <section class="agency-section fade-up">
        <div class="container">
            <div class="agency-grid">
                <div class="agency-image-wrapper">
                    <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?auto=format&fit=crop&w=800&q=80" alt="Search Engine Optimization Strategy">
                </div>
                <div class="agency-text">
                    <span class="eyebrow">WHY SEO</span>
                    <h2>Search Engine Optimization That Actually Moves Rankings</h2>
                    <p>Most SEO agencies sell reports full of vanity metrics. We focus on the fundamentals that actually move rankings and revenue: technical health, local visibility, and content that answers what your customers are searching for.</p>
                    <ul class="agency-list" style="margin-top: 20px;">
                        <li><i class="fa-solid fa-check"></i> Local SEO &amp; Google Business Profile Optimization</li>
                        <li><i class="fa-solid fa-check"></i> Technical SEO Audits &amp; Fixes</li>
                        <li><i class="fa-solid fa-check"></i> Content &amp; Link-Building Campaigns</li>
                    </ul>
                    <a href="/contact" class="btn-primary" style="margin-top: 10px;">Speak With An SEO Strategist</a>
                </div>
            </div>
        </div>
    </section>

    <!-- WHAT'S INCLUDED -->
    <section class="services-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">WHAT'S INCLUDED</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;">A Complete SEO Engine</h2>
            </div>
            <div class="industry-tile-grid">
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                    <h5>Technical SEO Audit</h5>
                    <p>Site speed, crawlability, indexing, and mobile usability fixes so search engines can properly find and rank you.</p>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-file-lines"></i></div>
                    <h5>On-Page Optimization</h5>
                    <p>Titles, meta descriptions, headings, and content structure aligned to the keywords your customers actually search.</p>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <h5>Local SEO &amp; Maps</h5>
                    <p>Google Business Profile management and citation building to dominate the local map pack.</p>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-link"></i></div>
                    <h5>Content &amp; Link Building</h5>
                    <p>Authority-building content and outreach campaigns that earn the backlinks Google rewards.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PROCESS -->
    <section class="methodology-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">OUR PROCESS</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;">How We Approach SEO</h2>
            </div>
            <div class="methodology-steps">
                <div class="m-step">
                    <div class="m-step-num">01</div>
                    <div class="m-step-content">
                        <h4><i class="fa-solid fa-magnifying-glass"></i> Discover &amp; Audit</h4>
                        <p>We audit your current site, rankings, and competitors to find the biggest opportunities.</p>
                    </div>
                </div>
                <div class="m-step">
                    <div class="m-step-num">02</div>
                    <div class="m-step-content">
                        <h4><i class="fa-solid fa-key"></i> Keyword &amp; Competitor Research</h4>
                        <p>We map the exact terms your customers search and how you can outrank competitors for them.</p>
                    </div>
                </div>
                <div class="m-step">
                    <div class="m-step-num">03</div>
                    <div class="m-step-content">
                        <h4><i class="fa-solid fa-screwdriver-wrench"></i> On-Page &amp; Technical Fixes</h4>
                        <p>We implement the structural and content changes needed to lift rankings.</p>
                    </div>
                </div>
                <div class="m-step">
                    <div class="m-step-num">04</div>
                    <div class="m-step-content">
                        <h4><i class="fa-solid fa-chart-line"></i> Content &amp; Authority Building</h4>
                        <p>We publish and promote content that builds topical authority and earns links over time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if ($seoCaseStudies): ?>
    <!-- REAL CLIENT WORK: every case study with verified results, pulled live
         from the same table the Case Studies admin section manages. -->
    <section class="services-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">VERIFIED RESULTS</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;">Real Campaigns. Real Numbers.</h2>
                <p style="color: var(--text-muted); max-width: 700px; margin: 15px auto 0; font-size: 1.05rem;">Every figure on this page comes straight from Google Search Console and Google Business Profile reporting for current clients -- not projections. Reporting windows vary by client.</p>
            </div>
            <div class="case-grid">
                <?php foreach ($seoCaseStudies as $cs): ?>
                <article class="case-card">
                    <div class="case-image">
                        <span class="case-tag"><?php echo htmlspecialchars($cs['tag'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($cs['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($cs['image_alt'], ENT_QUOTES, 'UTF-8'); ?>">
                        <h3><?php echo htmlspecialchars(strtoupper($cs['name']), ENT_QUOTES, 'UTF-8'); ?></h3>
                    </div>
                    <div class="case-content">
                        <div>
                            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 15px;"><?php echo htmlspecialchars(strip_tags($cs['summary']), ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <div>
                            <a href="/case-studies/<?php echo htmlspecialchars($cs['slug'], ENT_QUOTES, 'UTF-8'); ?>" class="service-link">View Details <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <div style="text-align: center; margin-top: clamp(30px, 4vw, 40px);">
                <a href="/case-studies" class="btn-secondary">VIEW ALL CASE STUDIES <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i></a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($seoStats): ?>
    <!-- STATS: combined real "Results At A Glance" stats from every case study
         with verified results, pulled live -- adding stats to a case study
         from the admin dashboard makes them appear here automatically. -->
    <section class="stats-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow" style="color: var(--cyan-neon);">PROVEN RESULTS</span>
                <h2 style="color: #fff; font-size: clamp(1.8rem, 4vw, 2.8rem);">SEO That Shows Up In The Numbers</h2>
            </div>
            <div class="stats-4-grid">
                <?php foreach ($seoStats as [$value, $label]): ?>
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

    <!-- FINAL CTA -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-box fade-up">
                <div class="cta-badge"><i class="fa-solid fa-rocket"></i> Let's Scale Together</div>
                <h2>Ready To Rank Higher?</h2>
                <p>Get a free SEO audit and see exactly what's holding your rankings back — and what it'll take to fix it.</p>
                <div class="cta-features">
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Zero Obligation Audit</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Custom Growth Strategy</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Proven Australian Results</span>
                </div>
                <div class="cta-btn-wrapper">
                    <a href="/contact" class="btn-primary" style="padding: 18px 45px; font-size: 1.1rem;">GET MY FREE SEO AUDIT <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>
