<?php
require_once __DIR__ . '/includes/cta-form-handler.php';
$page_title = 'Industries We Serve';
$page_description = 'Explore digital marketing for Australian businesses across accounting, automotive, construction, dental, ecommerce and other industries.';
include 'header.php';
?>

    <!-- INDUSTRIES HERO SECTION -->
    <section class="hero" style="padding-bottom: clamp(40px, 8vw, 80px);">
        <div class="container hero-content">
            <span class="eyebrow fade-up">INDUSTRIES WE SERVE</span>
            <h1 class="fade-up">DIGITAL MARKETING BUILT <br><span class="text-gradient">AROUND YOUR INDUSTRY.</span></h1>
            <p class="hero-subtitle fade-up">Your customers, services and sales process shape your marketing needs. Explore website, search and advertising services tailored to how people find and choose your business.</p>
        </div>
    </section>

    <!-- INDUSTRIES GRID SECTION -->
    <section class="industries-section fade-up" style="padding-top: 20px; padding-bottom: 100px;">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">SECTORS WE SUPPORT</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px; color: var(--navy);">Find The Right Approach For Your Business</h2>
            </div>
            
            <div class="industry-tile-grid">
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-calculator"></i></div>
                    <h5>Accounting & Finance</h5>
                    <p>Websites, search optimisation and content that help prospective clients understand your services and expertise.</p>
                    <a href="/accounting-finance" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-car"></i></div>
                    <h5>Automotive</h5>
                    <p>Local search, websites and advertising that help customers find your automotive business and make enquiries.</p>
                    <a href="/automotive" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-helmet-safety"></i></div>
                    <h5>Construction & Building</h5>
                    <p>Project portfolios and targeted marketing that showcase your capabilities and support relevant project enquiries.</p>
                    <a href="/construction-building" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-tooth"></i></div>
                    <h5>Dental</h5>
                    <p>Local search and clear practice websites that help prospective patients explore services and request appointments.</p>
                    <a href="/dental" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    <h5>Ecommerce</h5>
                    <p>Search, advertising and email campaigns that help online retailers reach shoppers and encourage repeat purchases.</p>
                    <a href="/ecommerce-industry" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-store"></i></div>
                    <h5>Franchise</h5>
                    <p>Coordinated marketing that supports individual locations while maintaining a consistent brand across your franchise.</p>
                    <a href="/franchise" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-user-doctor"></i></div>
                    <h5>Healthcare & Medical</h5>
                    <p>Clear service information and local visibility that help people find your practice and understand their options.</p>
                    <a href="/healthcare-medical" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-utensils"></i></div>
                    <h5>Hospitality & Tourism</h5>
                    <p>Websites and local campaigns that help customers discover your venue, explore experiences and make bookings.</p>
                    <a href="/hospitality-tourism" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-bed"></i></div>
                    <h5>Hotel & Motel</h5>
                    <p>Search and advertising campaigns that help travellers discover your property and explore direct booking options.</p>
                    <a href="/hotel-motel" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                    <h5>Legal & Law</h5>
                    <p>Practice area content and search optimisation that help prospective clients understand your expertise and make enquiries.</p>
                    <a href="/legal-law" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-house"></i></div>
                    <h5>Real Estate</h5>
                    <p>Local search, property marketing and agent branding that support buyer, seller and landlord enquiries.</p>
                    <a href="/real-estate" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-shop"></i></div>
                    <h5>Small Business</h5>
                    <p>Practical websites, search optimisation and advertising shaped around your services, priorities and available budget.</p>
                    <a href="/small-business-digital-marketing" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                    <h5>NDIS</h5>
                    <p>Clear websites and service information that help participants, families and support coordinators understand your offering.</p>
                    <a href="/ndis" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="industry-tile">
                    <div class="industry-tile-icon"><i class="fa-solid fa-truck-fast"></i></div>
                    <h5>Trades</h5>
                    <p>Local search and service websites that help customers find your trade business and request quotes or repairs.</p>
                    <a href="/trades" class="industry-tile-btn">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- STATISTICS PROOF STRIP -->
    <section class="stats-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow" style="color: var(--cyan-neon);">PROVEN IMPACT</span>
                <h2 style="color: #fff; font-size: clamp(1.8rem, 4vw, 2.8rem);">Driving Growth Across All Sectors</h2>
            </div>
            <div class="stats-4-grid">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <h3>Top 3</h3>
                    <p>Avg. Local Map Ranking</p>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-user-plus"></i></div>
                    <h3>+193</h3>
                    <p>Leads Generated</p>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-arrow-trend-down"></i></div>
                    <h3>-31%</h3>
                    <p>Cost Per Lead</p>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                    <h3>+68%</h3>
                    <p>Revenue Growth</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PREMIUM FINAL CTA SECTION -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-box cta-box-split fade-up">
                <div class="cta-info">
                    <div class="cta-badge"><i class="fa-solid fa-rocket"></i> Let's Scale Together</div>
                    <h2>Ready To Dominate Your Industry?</h2>
                    <p>Partner with W&S Digital Marketing to build a custom, data-driven growth plan tailored specifically to your market sector.</p>
                    <div class="cta-features">
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Zero Obligation Audit</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Custom Growth Strategy</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Proven Australian Results</span>
                    </div>
                </div>
                <div class="cta-form-wrap">
                    <?php $cta_button_label = 'GET MY FREE GROWTH PLAN'; include __DIR__ . '/includes/cta-form.php'; ?>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>