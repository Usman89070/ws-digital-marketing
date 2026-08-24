<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/case-study-helpers.php';

$ecommerceCaseStudies = [];
$ecommerceStats = [];
try {
    // Every case study whose tag includes "Ecommerce" (alone or combined with
    // other services) -- shown below as real proof, and as the source for the
    // "Proven Results" stats grid. Pulled live from the same table the Case
    // Studies admin section manages, so a new ecommerce project tagged this
    // way -- and any "Results At A Glance" stats added for it from the
    // dashboard -- appears here automatically.
    $rows = get_db()->query("SELECT slug, name, tag, image_path, image_alt, summary, stat1_value, stat1_label, stat2_value, stat2_label, stat3_value, stat3_label, stat4_value, stat4_label FROM case_studies ORDER BY display_order ASC")->fetchAll();
    foreach ($rows as $row) {
        if (!case_study_tag_has($row['tag'], 'ecommerce')) {
            continue;
        }
        $ecommerceCaseStudies[] = $row;
        foreach ([1, 2, 3, 4] as $n) {
            if ($row["stat{$n}_value"] !== '' || $row["stat{$n}_label"] !== '') {
                $ecommerceStats[] = [$row["stat{$n}_value"], $row["stat{$n}_label"]];
            }
        }
    }
    // Stats sharing the same label (e.g. multiple businesses' "Organic
    // Clicks") are combined into one box instead of shown per-business.
    $ecommerceStats = combine_stats($ecommerceStats);
} catch (PDOException $e) {
    $ecommerceCaseStudies = [];
    $ecommerceStats = [];
}

$page_title = 'E-commerce';
$page_description = 'Shopify and WooCommerce builds, catalog strategy, and conversion-focused checkout flows that turn browsers into repeat customers.';
include 'header.php';
?>

    <!-- ECOMMERCE HERO SECTION -->
    <section class="hero" style="padding-bottom: clamp(40px, 8vw, 80px);">
        <div class="container hero-content">
            <span class="eyebrow fade-up">E-COMMERCE</span>
            <h1 class="fade-up">TURN BROWSERS <br><span class="text-gradient">INTO BUYERS.</span></h1>
            <p class="hero-subtitle fade-up">From store builds to checkout optimization, we build and grow ecommerce stores engineered to convert traffic into repeat revenue.</p>
            <div class="hero-buttons fade-up">
                <a href="/contact" class="btn-primary">GET MY FREE STORE AUDIT <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                <a href="/services" class="btn-secondary">VIEW ALL SERVICES</a>
            </div>
        </div>
    </section>

    <!-- INTRO SECTION -->
    <section class="agency-section fade-up">
        <div class="container">
            <div class="agency-grid">
                <div class="agency-image-wrapper">
                    <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=800&q=80" alt="E-commerce Store Strategy">
                </div>
                <div class="agency-text">
                    <span class="eyebrow">WHY IT MATTERS</span>
                    <h2>Ecommerce Built Around Conversion, Not Just Aesthetics</h2>
                    <p>A beautiful store that doesn't convert is just an expensive brochure. We build and optimize Shopify and WooCommerce stores around the entire buying journey — from first click to repeat purchase.</p>
                    <ul class="agency-list" style="margin-top: 20px;">
                        <li><i class="fa-solid fa-check"></i> Shopify &amp; WooCommerce Builds And Migrations</li>
                        <li><i class="fa-solid fa-check"></i> Conversion-Focused Checkout Flows</li>
                        <li><i class="fa-solid fa-check"></i> Product Feed &amp; Shopping Ads Management</li>
                    </ul>
                    <a href="/contact" class="btn-primary" style="margin-top: 10px;">Speak With An Ecommerce Strategist</a>
                </div>
            </div>
        </div>
    </section>

    <!-- WHAT'S INCLUDED -->
    <section class="services-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">WHAT'S INCLUDED</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;">A Complete Ecommerce Growth Engine</h2>
            </div>
            <div class="industry-tile-grid">
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-store"></i></div>
                    <h5>Store Setup &amp; Migration</h5>
                    <p>Clean, fast Shopify or WooCommerce builds — or a seamless migration from your current platform.</p>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                    <h5>Catalog &amp; Product Strategy</h5>
                    <p>Product page structure, collections, and merchandising built to guide customers to checkout.</p>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-credit-card"></i></div>
                    <h5>Checkout &amp; CRO</h5>
                    <p>Cart and checkout optimization to recover abandonment and lift conversion rate.</p>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-bullhorn"></i></div>
                    <h5>Shopping Ads &amp; Feed Management</h5>
                    <p>Google Shopping and Meta catalog ads managed to keep your best sellers in front of buyers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PROCESS -->
    <section class="methodology-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">OUR PROCESS</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;">How We Build Ecommerce Growth</h2>
            </div>
            <div class="methodology-steps">
                <div class="m-step">
                    <div class="m-step-num">01</div>
                    <div class="m-step-content">
                        <h4><i class="fa-solid fa-magnifying-glass"></i> Audit &amp; Strategy</h4>
                        <p>We review your store's funnel end-to-end and identify where revenue is leaking.</p>
                    </div>
                </div>
                <div class="m-step">
                    <div class="m-step-num">02</div>
                    <div class="m-step-content">
                        <h4><i class="fa-solid fa-hammer"></i> Build Or Migrate</h4>
                        <p>We build your store from scratch or migrate it cleanly with zero data loss.</p>
                    </div>
                </div>
                <div class="m-step">
                    <div class="m-step-num">03</div>
                    <div class="m-step-content">
                        <h4><i class="fa-solid fa-gauge-high"></i> Optimize Conversion</h4>
                        <p>We test and refine product pages, checkout, and offers to lift conversion rate.</p>
                    </div>
                </div>
                <div class="m-step">
                    <div class="m-step-num">04</div>
                    <div class="m-step-content">
                        <h4><i class="fa-solid fa-rocket"></i> Launch &amp; Scale</h4>
                        <p>We layer in paid and organic traffic strategies to scale revenue predictably.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if ($ecommerceCaseStudies): ?>
    <!-- REAL ECOMMERCE CLIENT WORK -->
    <section class="services-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">REAL CLIENT WORK</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;">Ecommerce Projects We've Delivered</h2>
            </div>
            <div class="case-grid">
                <?php foreach ($ecommerceCaseStudies as $cs): ?>
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
                <a href="/case-studies" class="service-link"><i class="fa-solid fa-arrow-left"></i> View All Case Studies</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($ecommerceStats): ?>
    <!-- STATS: combined real "Results At A Glance" stats from every ecommerce-
         tagged case study, pulled live -- adding stats to an ecommerce case
         study from the admin dashboard makes them appear here automatically. -->
    <section class="stats-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow" style="color: var(--cyan-neon);">PROVEN RESULTS</span>
                <h2 style="color: #fff; font-size: clamp(1.8rem, 4vw, 2.8rem);">Real Ecommerce Results, Verified From Client Reporting</h2>
            </div>
            <div class="stats-4-grid">
                <?php foreach ($ecommerceStats as [$value, $label]): ?>
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
                <h2>Ready To Grow Your Store?</h2>
                <p>Get a free store audit and see exactly where you're losing sales — and how to fix it.</p>
                <div class="cta-features">
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Zero Obligation Audit</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Custom Growth Strategy</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Proven Australian Results</span>
                </div>
                <div class="cta-btn-wrapper">
                    <a href="/contact" class="btn-primary" style="padding: 18px 45px; font-size: 1.1rem;">GET MY FREE STORE AUDIT <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>
