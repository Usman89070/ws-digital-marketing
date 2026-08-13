<?php
$page_title = 'Blog';
$page_description = 'Digital marketing insights, SEO tips, and growth strategies from the W&S Digital Marketing team to help Australian businesses grow online.';
include 'header.php';
?>

    <!-- BLOG HERO SECTION -->
    <section class="hero" style="padding-bottom: clamp(40px, 8vw, 80px);">
        <div class="container hero-content">
            <span class="eyebrow fade-up">INSIGHTS</span>
            <h1 class="fade-up">GROWTH STRATEGIES, <br><span class="text-gradient">STRAIGHT FROM THE TEAM.</span></h1>
            <p class="hero-subtitle fade-up">Practical SEO, PPC and growth marketing insights to help you make smarter decisions about your online presence.</p>
        </div>
    </section>

    <!-- BLOG GRID SECTION -->
    <section class="case-studies-section fade-up">
        <div class="container">
            <div class="case-grid">

                <article class="case-card">
                    <div class="case-image">
                        <span class="case-tag">SEO</span>
                        <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1571171637578-41bc2dd41cd2?auto=format&fit=crop&w=800&q=80" alt="Local SEO strategy for Australian small businesses">
                        <h3>5 Local SEO Wins Every Small Business Should Make</h3>
                    </div>
                    <div class="case-content">
                        <div>
                            <p>From Google Business Profile optimization to local link building, here are the highest-leverage local SEO moves for Australian businesses.</p>
                        </div>
                        <div>
                            <a href="contact.php" class="service-link">Talk To Our Team <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>

                <article class="case-card">
                    <div class="case-image">
                        <span class="case-tag">PPC</span>
                        <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1533750349088-cd871a92f312?auto=format&fit=crop&w=800&q=80" alt="Google Ads budget optimization">
                        <h3>How To Stop Wasting Ad Spend On Google Ads</h3>
                    </div>
                    <div class="case-content">
                        <div>
                            <p>Negative keywords, dayparting, and audience layering — the tactics we use to cut cost-per-lead without sacrificing volume.</p>
                        </div>
                        <div>
                            <a href="contact.php" class="service-link">Talk To Our Team <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>

                <article class="case-card">
                    <div class="case-image">
                        <span class="case-tag">CRO</span>
                        <img loading="lazy" decoding="async" src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80" alt="Website conversion rate optimization">
                        <h3>Why Your Website Isn't Converting Traffic Into Leads</h3>
                    </div>
                    <div class="case-content">
                        <div>
                            <p>Traffic isn't the problem for most businesses — conversion is. Here's how we audit and fix leaky landing pages.</p>
                        </div>
                        <div>
                            <a href="contact.php" class="service-link">Talk To Our Team <i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- FINAL CTA SECTION -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-box fade-up">
                <div class="cta-badge"><i class="fa-solid fa-rocket"></i> Let's Scale Together</div>
                <h2>Ready To Put This Into Practice?</h2>
                <p>Skip the guesswork. Let our team build and run a custom growth strategy for your business.</p>
                <div class="cta-features">
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Zero Obligation Audit</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Custom Growth Strategy</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Proven Australian Results</span>
                </div>
                <div class="cta-btn-wrapper">
                    <a href="contact.php" class="btn-primary" style="padding: 18px 45px; font-size: 1.1rem;">GET MY FREE GROWTH PLAN <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>
