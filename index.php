<?php
require_once __DIR__ . '/includes/cta-form-handler.php';

$page_title = 'Digital Marketing Agency Australia';
$page_description = 'Grow your Australian business with SEO, Google Ads, social media and website design from W&S Digital Marketing. Request your free growth plan today.';
include 'header.php';
?>

    <!-- SECTION 1: HERO -->
    <section id="hero" class="hero">
        <div class="container hero-content">
            <span class="eyebrow fade-up">YOUR BUSINESS. OUR FOCUS.</span>
            <h1 class="fade-up">DIGITAL MARKETING <br><span class="text-gradient">BUILT TO GROW YOUR BUSINESS.</span></h1>
            <p class="hero-subtitle fade-up">SEO, Google Ads, social media and website design that help Australian businesses attract the right customers, generate more enquiries and increase online sales.</p>

            <div class="hero-buttons fade-up">
                <a href="#contact" class="btn-primary">GET MY FREE GROWTH PLAN <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></a>
                <a href="/case-studies" class="btn-secondary">VIEW OUR WORK</a>
            </div>
        </div>
    </section>

    <!-- SECTION 2: MASTER CINEMATIC STAGE -->
    <div class="cinematic-wrapper">
        <div class="devices-stage">
            <div class="stage-header">
                <span class="eyebrow">Real Time Analytics</span>
                <h2>MARKETING THAT MOVES THE NUMBERS</h2>
            </div>
            
            <div class="scatter-item fs-1"><span>Total Clicks</span> <div class="val">2.71K <i class="fa-solid fa-arrow-trend-up"></i></div></div>
            <div class="scatter-item fs-2"><span>Total Impressions</span> <div class="val">71.9K <i class="fa-solid fa-chart-column"></i></div></div>
            <div class="scatter-item fs-3"><span>Average CTR</span> <div class="val">3.8% <i class="fa-solid fa-bullseye"></i></div></div>
            <div class="scatter-item fs-4"><span>Average Position</span> <div class="val">12.5 <i class="fa-solid fa-trophy"></i></div></div>
            
            <!-- Laptop (Hidden on Mobile) -->
            <div class="laptop-container">
                <div class="mac-screen-bezel">
                    <div class="mac-camera"></div>
                    <div class="dashboard-ui">
                        <div class="dash-sidebar">
                            <div class="icon" style="background: var(--cyan-neon);"></div>
                            <div class="icon"></div>
                            <div class="icon"></div>
                        </div>
                        <div class="dash-main">
                            <div class="dash-topbar">
                                <div class="dash-title">SEO Ranking Results</div>
                            </div>
                            <div class="dash-cards">
                                <div class="dash-card"><div class="dash-card-title">Total Clicks</div><div class="dash-card-value">2.71K</div></div>
                                <div class="dash-card"><div class="dash-card-title">Total Impressions</div><div class="dash-card-value">71.9K</div></div>
                                <div class="dash-card"><div class="dash-card-title">Average CTR</div><div class="dash-card-value">3.8%</div></div>
                                <div class="dash-card"><div class="dash-card-title">Average Position</div><div class="dash-card-value">12.5</div></div>
                            </div>
                            <div class="dash-chart-area">
                                <span style="font-weight: 700; font-size: 0.85rem; color: var(--navy); z-index: 10; position: relative;">SEO Ranking Growth Analytics</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mac-base"><div class="mac-notch"></div></div>
            </div>

            <!-- Mobile Phone -->
            <div class="mobile-container">
                <div class="iphone-island"></div>
                <div class="phone-inner">
                    <div class="serp-screen-wrapper">
                        <div class="serp-screen">
                            <div class="serp-item">
                                <a href="https://wsdigitalmarketing.com.au" target="_blank" rel="noopener noreferrer" class="serp-link">
                                    <div class="serp-url"><img loading="lazy" decoding="async" src="https://wsdigitalmarketing.com.au/favicon.ico" onerror="this.style.display='none'"> wsdigitalmarketing.com.au</div>
                                    <div class="serp-title">W&S Digital Marketing | #1 Agency in Australia</div>
                                    <div class="serp-desc">Drive high-intent traffic, build custom sites, and scale revenue.</div>
                                </a>
                            </div>
                            <div class="serp-item">
                                <a href="https://wsdigitalmarketing.com.au/seo" target="_blank" rel="noopener noreferrer" class="serp-link">
                                    <div class="serp-url"><img loading="lazy" decoding="async" src="https://wsdigitalmarketing.com.au/favicon.ico" onerror="this.style.display='none'"> wsdigitalmarketing.com.au › seo</div>
                                    <div class="serp-title">Search Engine Optimisation Services</div>
                                    <div class="serp-desc">Dominate local search results and Google Maps effortlessly.</div>
                                </a>
                            </div>
                            <div class="serp-item">
                                <a href="https://wsdigitalmarketing.com.au/ppc" target="_blank" rel="noopener noreferrer" class="serp-link">
                                    <div class="serp-url"><img loading="lazy" decoding="async" src="https://wsdigitalmarketing.com.au/favicon.ico" onerror="this.style.display='none'"> wsdigitalmarketing.com.au › ppc</div>
                                    <div class="serp-title">Google Ads & PPC Management</div>
                                    <div class="serp-desc">Maximize your ROAS and get instant high-converting calls.</div>
                                </a>
                            </div>
                            <div class="serp-item">
                                <a href="https://wsdigitalmarketing.com.au/web-design" target="_blank" rel="noopener noreferrer" class="serp-link">
                                    <div class="serp-url"><img loading="lazy" decoding="async" src="https://wsdigitalmarketing.com.au/favicon.ico" onerror="this.style.display='none'"> wsdigitalmarketing.com.au › web-design</div>
                                    <div class="serp-title">Web Design & CRO Solutions</div>
                                    <div class="serp-desc">Fast, responsive websites engineered specifically to convert.</div>
                                </a>
                            </div>
                            <div class="serp-item">
                                <a href="https://wsdigitalmarketing.com.au/contact" target="_blank" rel="noopener noreferrer" class="serp-link">
                                    <div class="serp-url"><img loading="lazy" decoding="async" src="https://wsdigitalmarketing.com.au/favicon.ico" onerror="this.style.display='none'"> wsdigitalmarketing.com.au › contact</div>
                                    <div class="serp-title">Contact W&S Digital - Get a Free Plan</div>
                                    <div class="serp-desc">Ready to scale your business revenue? Get in touch today.</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="logo-screen">
                        <img loading="lazy" decoding="async" src="/images/logo-ws.webp" alt="W&S Animated Logo">
                        <div class="logo-screen-sub">Measurable Growth</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MOBILE EXCLUSIVE PERFORMANCE OVERVIEW -->
    <div class="mobile-perf-overview fade-up">
        <div class="container">
            <div class="dash-ui-mobile">
                <div class="dash-topbar" style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
                    <div class="dash-title" style="font-weight: 700; font-size: 1.1rem; color: var(--navy);">SEO Ranking Results</div>
                    <span style="font-size: 11px; color: var(--text-muted); background: var(--bg-secondary); padding: 5px 12px; border-radius: 15px; border: 1px solid var(--border-light);">Last 30 Days <i class="fa-solid fa-chevron-down" style="margin-left:3px;"></i></span>
                </div>
                <div class="mobile-dash-cards">
                    <div class="m-dash-card"><div class="m-dash-card-title">Total Clicks</div><div class="m-dash-card-value">2.71K</div></div>
                    <div class="m-dash-card"><div class="m-dash-card-title">Impressions</div><div class="m-dash-card-value">71.9K</div></div>
                    <div class="m-dash-card"><div class="m-dash-card-title">Avg CTR</div><div class="m-dash-card-value">3.8%</div></div>
                    <div class="m-dash-card"><div class="m-dash-card-title">Avg Position</div><div class="m-dash-card-value">12.5</div></div>
                </div>
            </div>
        </div>
    </div>

    <!-- TRUSTED STRIP (MARQUEE) -->
    <div class="trusted-strip-wrapper fade-up">
        <div class="partner-marquee">
            <div class="partner-marquee-track">
                <div class="partner-strip">
                    <div><i class="fa-brands fa-google" style="color: #4285F4; margin-right: 5px;"></i> Google <span>Partner</span></div>
                    <div><i class="fa-brands fa-meta" style="color: #0668E1; margin-right: 5px;"></i> Meta <span>Business</span></div>
                    <div><i class="fa-solid fa-chart-simple" style="color: #F26722; margin-right: 5px;"></i> SEMRUSH</div>
                    <div><i class="fa-solid fa-brain" style="color: #D97706; margin-right: 5px;"></i> CLAUDE</div>
                    <div><i class="fa-brands fa-shopify" style="color: #96bf48; margin-right: 5px;"></i> shopify</div>
                </div>
                <div class="partner-strip" aria-hidden="true">
                    <div><i class="fa-brands fa-google" style="color: #4285F4; margin-right: 5px;"></i> Google <span>Partner</span></div>
                    <div><i class="fa-brands fa-meta" style="color: #0668E1; margin-right: 5px;"></i> Meta <span>Business</span></div>
                    <div><i class="fa-solid fa-chart-simple" style="color: #F26722; margin-right: 5px;"></i> SEMRUSH</div>
                    <div><i class="fa-solid fa-brain" style="color: #D97706; margin-right: 5px;"></i> CLAUDE</div>
                    <div><i class="fa-brands fa-shopify" style="color: #96bf48; margin-right: 5px;"></i> shopify</div>
                </div>
            </div>
        </div>
    </div>

    <!-- UPGRADED SERVICES SECTION WITH REAL IMAGES -->
    <section id="services" class="services-section fade-up">
        <div class="container">
            <div class="section-header">
                <span class="eyebrow">OUR EXPERTISE</span>
                <h2 style="font-size: clamp(1.8rem, 4vw, 2.8rem); margin-top: 10px;">Digital Services For Your Business</h2>
            </div>
            <div class="services-grid">
                <!-- Service 1: SEO -->
                <div class="service-card service-card-flip">
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
                                <p>Improve your visibility in Google Search and Maps with technical improvements, useful content and local optimisation that help relevant customers find your business.</p>
                                <a href="/seo" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Service 2: Ecommerce -->
                <div class="service-card service-card-flip">
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
                                <p>Build or improve your Shopify or WooCommerce store with clear product information, organised collections and a straightforward shopping experience from browsing to checkout.</p>
                                <a href="/ecommerce" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Service 3: Website Design & Development -->
                <div class="service-card service-card-flip">
                    <div class="service-card-inner">
                        <div class="service-card-front">
                            <div class="service-icon-badge"><i class="fa-solid fa-laptop-code"></i></div>
                            <h3>Website Design & Development</h3>
                        </div>
                        <div class="service-card-back">
                            <img loading="lazy" decoding="async" class="service-card-back-img" src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=80" alt="">
                            <div class="service-card-back-overlay"></div>
                            <div class="service-card-back-content">
                                <p class="service-card-back-title" aria-hidden="true">Website Design & Development</p>
                                <p>Fast, mobile-friendly websites with clear navigation and practical features that make it easier for customers to enquire, book a service or buy.</p>
                                <a href="/website-development" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Service 4: Social Media -->
                <div class="service-card service-card-flip">
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
                                <p>Keep your social channels active with planned content, consistent posting and community engagement that help customers understand and connect with your business.</p>
                                <a href="/social-media" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Service 5: Paid Advertising -->
                <div class="service-card service-card-flip">
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
                                <p>Reach relevant customers through Google Ads and paid social campaigns, with ongoing testing and reporting focused on enquiries, purchases and advertising costs.</p>
                                <a href="/ppc-advertising" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Service 6: Graphic Design -->
                <div class="service-card service-card-flip">
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
                                <p>Create a consistent business identity with logo design, social media graphics, advertising creative and marketing materials that reflect your brand across every channel.</p>
                                <a href="/graphic-design" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Service 7: Content Writing -->
                <div class="service-card service-card-flip">
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
                                <p>Clear website copy, product descriptions and blog articles shaped around customer questions, helping people understand your services and supporting your visibility in search.</p>
                                <a href="/content-writing" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: clamp(30px, 4vw, 40px);">
                <a href="/services" class="btn-secondary">VIEW ALL SERVICES <i class="fa-solid fa-arrow-right" style="margin-left: 6px;"></i></a>
            </div>
        </div>
    </section>

    <!-- PREMIUM FINAL CTA SECTION -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="cta-box cta-box-split fade-up">
                <div class="cta-info">
                    <div class="cta-badge"><i class="fa-solid fa-rocket"></i> Let's Scale Together</div>
                    <h2>Ready To Grow Your Business?</h2>
                    <p>Partner with W&S Digital Marketing to build a custom, data-driven growth plan that generates high-intent leads, sales, and maximum ROAS.</p>
                    <div class="cta-features">
                        <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Zero Obligation Audit</span>
                        <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Custom Growth Strategy</span>
                        <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Proven Australian Results</span>
                    </div>
                </div>
                <div class="cta-form-wrap">
                    <?php $cta_button_label = 'REQUEST MY FREE GROWTH PLAN'; include __DIR__ . '/includes/cta-form.php'; ?>
                </div>
            </div>
        </div>
    </section>

<?php include 'footer.php'; ?>