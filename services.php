<?php
require_once __DIR__ . '/includes/cta-form-handler.php';
$page_title = 'Digital Marketing Services';
$page_description = 'SEO, PPC, eCommerce, web design, social media, graphic design and content writing services engineered to generate measurable growth for Australian businesses.';
include 'header.php';
?>

    <!-- SERVICES HERO SECTION -->
    <section class="hero" style="padding-bottom: clamp(40px, 8vw, 80px);">
        <div class="container hero-content">
            <span class="eyebrow fade-up">OUR SERVICES</span>
            <h1 class="fade-up">FULL-SERVICE DIGITAL MARKETING <br><span class="text-gradient">BUILT TO CONVERT.</span></h1>
            <p class="hero-subtitle fade-up">From organic search to paid ads, ecommerce builds to brand content — every service we offer is engineered around one goal: measurable revenue growth.</p>
        </div>
    </section>

    <!-- SERVICES OVERVIEW GRID -->
    <section class="services-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">WHAT WE DO</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;">Seven Disciplines. One Growth Engine.</h2>
            </div>
            <div class="services-grid">

                <div class="service-card service-card-flip" id="seo" style="scroll-margin-top: 110px;">
                    <div class="service-card-inner">
                        <div class="service-card-front">
                            <div class="service-icon-badge"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                            <h3>Search Engine Optimisation</h3>
                        </div>
                        <div class="service-card-back">
                            <img loading="lazy" decoding="async" class="service-card-back-img" src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?auto=format&fit=crop&w=800&q=80" alt="">
                            <div class="service-card-back-overlay"></div>
                            <div class="service-card-back-content">
                                <p class="service-card-back-title" aria-hidden="true">Search Engine Optimisation</p>
                                <p>Dominate local search and Google Maps with technical SEO, content, and link-building strategies that attract high-intent organic traffic.</p>
                                <a href="/seo" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card service-card-flip" id="ecom" style="scroll-margin-top: 110px;">
                    <div class="service-card-inner">
                        <div class="service-card-front">
                            <div class="service-icon-badge"><i class="fa-solid fa-cart-shopping"></i></div>
                            <h3>Ecommerce</h3>
                        </div>
                        <div class="service-card-back">
                            <img loading="lazy" decoding="async" class="service-card-back-img" src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=800&q=80" alt="">
                            <div class="service-card-back-overlay"></div>
                            <div class="service-card-back-content">
                                <p class="service-card-back-title" aria-hidden="true">Ecommerce</p>
                                <p>Shopify and WooCommerce builds, catalog strategy, and conversion-focused checkout flows that turn browsers into repeat customers.</p>
                                <a href="/ecommerce" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card service-card-flip" id="web" style="scroll-margin-top: 110px;">
                    <div class="service-card-inner">
                        <div class="service-card-front">
                            <div class="service-icon-badge"><i class="fa-solid fa-laptop-code"></i></div>
                            <h3>Website Design &amp; Development</h3>
                        </div>
                        <div class="service-card-back">
                            <img loading="lazy" decoding="async" class="service-card-back-img" src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=80" alt="">
                            <div class="service-card-back-overlay"></div>
                            <div class="service-card-back-content">
                                <p class="service-card-back-title" aria-hidden="true">Website Design &amp; Development</p>
                                <p>Fast, mobile-responsive websites engineered specifically for conversion rate optimization, not just aesthetics.</p>
                                <a href="/website-development" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card service-card-flip" id="social" style="scroll-margin-top: 110px;">
                    <div class="service-card-inner">
                        <div class="service-card-front">
                            <div class="service-icon-badge"><i class="fa-solid fa-share-nodes"></i></div>
                            <h3>Social Media Marketing</h3>
                        </div>
                        <div class="service-card-back">
                            <img loading="lazy" decoding="async" class="service-card-back-img" src="/images/socialMedia.webp" alt="">
                            <div class="service-card-back-overlay"></div>
                            <div class="service-card-back-content">
                                <p class="service-card-back-title" aria-hidden="true">Social Media Marketing</p>
                                <p>Strategic content and community management across Meta and TikTok to build brand presence and engage your target audience.</p>
                                <a href="/social-media" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card service-card-flip" id="ppc" style="scroll-margin-top: 110px;">
                    <div class="service-card-inner">
                        <div class="service-card-front">
                            <div class="service-icon-badge"><i class="fa-solid fa-hand-pointer"></i></div>
                            <h3>Paid Advertising</h3>
                        </div>
                        <div class="service-card-back">
                            <img loading="lazy" decoding="async" class="service-card-back-img" src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80" alt="">
                            <div class="service-card-back-overlay"></div>
                            <div class="service-card-back-content">
                                <p class="service-card-back-title" aria-hidden="true">Paid Advertising</p>
                                <p>Google Ads and paid social campaigns built for instant, high-converting traffic, more phone calls, and maximum ROAS.</p>
                                <a href="/ppc-advertising" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card service-card-flip" id="graphic" style="scroll-margin-top: 110px;">
                    <div class="service-card-inner">
                        <div class="service-card-front">
                            <div class="service-icon-badge"><i class="fa-solid fa-palette"></i></div>
                            <h3>Graphic Design</h3>
                        </div>
                        <div class="service-card-back">
                            <img loading="lazy" decoding="async" class="service-card-back-img" src="https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=800&q=80" alt="">
                            <div class="service-card-back-overlay"></div>
                            <div class="service-card-back-content">
                                <p class="service-card-back-title" aria-hidden="true">Graphic Design</p>
                                <p>Brand identity, ad creative, and marketing collateral designed to stand out and stay consistent across every channel.</p>
                                <a href="/graphic-design" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="service-card service-card-flip" id="content" style="scroll-margin-top: 110px;">
                    <div class="service-card-inner">
                        <div class="service-card-front">
                            <div class="service-icon-badge"><i class="fa-solid fa-pen-nib"></i></div>
                            <h3>Content Writing</h3>
                        </div>
                        <div class="service-card-back">
                            <img loading="lazy" decoding="async" class="service-card-back-img" src="https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=800&q=80" alt="">
                            <div class="service-card-back-overlay"></div>
                            <div class="service-card-back-content">
                                <p class="service-card-back-title" aria-hidden="true">Content Writing</p>
                                <p>SEO-optimized copy, blog content, and website content that ranks, builds authority, and speaks directly to your customers.</p>
                                <a href="/content-writing" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FINAL CTA SECTION -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-box cta-box-split fade-up">
                <div class="cta-info">
                    <div class="cta-badge"><i class="fa-solid fa-rocket"></i> Let's Scale Together</div>
                    <h2>Not Sure Which Service You Need?</h2>
                    <p>Book a zero-obligation audit and we'll recommend the exact mix of services to hit your growth goals.</p>
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
