<?php
// Homepage enquiry form (inside the "Ready To Grow Your Business?" section
// below) -- same header-injection-safe mail handling as contact.php's form.
$home_email_sent = false;
$home_form_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Strip control characters (incl. CR/LF) to prevent email header injection,
    // then strip tags and trim on top of that.
    $clean = function ($value) {
        $value = preg_replace('/[\r\n\x00-\x1F\x7F]/', '', (string) $value);
        return trim(strip_tags($value));
    };

    $home_name    = $clean($_POST['name'] ?? '');
    $home_email   = filter_var($clean($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $home_phone   = $clean($_POST['phone'] ?? '');
    $home_service = $clean($_POST['service'] ?? '');
    $home_message = $clean($_POST['message'] ?? '');

    if ($home_name === '' || $home_message === '' || !filter_var($home_email, FILTER_VALIDATE_EMAIL)) {
        $home_form_error = 'Please fill in your name, a valid email address, and your message.';
    } else {
        $to = "info@wsdigitalmarketing.com.au";
        $subject = "New Growth Plan Request from " . $home_name;

        $email_content = "Name: $home_name\n";
        $email_content .= "Email: $home_email\n";
        $email_content .= "Phone: $home_phone\n";
        $email_content .= "Service Needed: $home_service\n";
        $email_content .= "\nMessage:\n$home_message\n";

        // Reply-To carries the visitor's address; From stays a domain address
        // the sending server is authorized for, avoiding SPF/DMARC failures.
        $headers = "From: W&S Digital Marketing <info@wsdigitalmarketing.com.au>\r\n";
        $headers .= "Reply-To: $home_name <$home_email>\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $email_content, $headers)) {
            $home_email_sent = true;
        } else {
            $home_form_error = 'Something went wrong sending your message. Please try again or email us directly at info@wsdigitalmarketing.com.au.';
        }
    }
}

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
            <div class="cta-box fade-up">
                <div class="cta-badge"><i class="fa-solid fa-rocket"></i> Let's Scale Together</div>
                <h2>Ready To Grow Your Business?</h2>
                <p>Partner with W&S Digital Marketing to build a custom, data-driven growth plan that generates high-intent leads, sales, and maximum ROAS.</p>
                <div class="cta-features">
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Zero Obligation Audit</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Custom Growth Strategy</span>
                    <span><i class="fa-solid fa-check" style="color: var(--cyan-neon);"></i> Proven Australian Results</span>
                </div>

                <?php if ($home_email_sent): ?>
                    <div style="background: #D1E7DD; color: #0F5132; padding: 18px; border-radius: 12px; margin-bottom: 10px; text-align: center; font-weight: 600; border: 1px solid #badbcc;">
                        <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> Thank you! Your message has been successfully sent. We will get back to you shortly.
                    </div>
                <?php elseif ($home_form_error): ?>
                    <div style="background: #F8D7DA; color: #842029; padding: 18px; border-radius: 12px; margin-bottom: 10px; text-align: center; font-weight: 600; border: 1px solid #f5c2c7;">
                        <i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i> <?php echo htmlspecialchars($home_form_error, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>

                <?php if (!$home_email_sent): ?>
                <form action="/#contact" method="POST" class="home-enquiry-form">
                    <div class="home-enquiry-row">
                        <div class="home-enquiry-field">
                            <label for="home-name">Your Name *</label>
                            <input type="text" id="home-name" name="name" placeholder="John Smith" required value="<?php echo htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="home-enquiry-field">
                            <label for="home-email">Email Address *</label>
                            <input type="email" id="home-email" name="email" placeholder="john@example.com" required value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                    <div class="home-enquiry-row">
                        <div class="home-enquiry-field">
                            <label for="home-phone">Phone Number (optional)</label>
                            <input type="tel" id="home-phone" name="phone" placeholder="0400 000 000" value="<?php echo htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="home-enquiry-field">
                            <label for="home-service">Service Needed</label>
                            <select id="home-service" name="service">
                                <option value="Search Engine Optimisation">Search Engine Optimisation</option>
                                <option value="Ecommerce">Ecommerce</option>
                                <option value="Website Design & Development">Website Design &amp; Development</option>
                                <option value="Social Media Marketing">Social Media Marketing</option>
                                <option value="Paid Advertising">Paid Advertising</option>
                                <option value="Graphic Design">Graphic Design</option>
                                <option value="Content Writing">Content Writing</option>
                                <option value="Not sure / Multiple services" selected>Not sure / Multiple services</option>
                            </select>
                        </div>
                    </div>
                    <div class="home-enquiry-field">
                        <label for="home-message">Tell Us About Your Project *</label>
                        <textarea id="home-message" name="message" rows="3" placeholder="Share your goals, current challenges, or what you'd like to achieve..." required><?php echo htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                    <p class="home-enquiry-privacy">By submitting this form, you agree to our <a href="/privacy-policy">Privacy Policy</a>.</p>
                    <div class="cta-btn-wrapper">
                        <button type="submit" class="btn-primary" style="padding: 18px 45px; font-size: 1.1rem; cursor: pointer;">REQUEST MY FREE GROWTH PLAN <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i></button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Homepage Enquiry Form Styling: light inputs readable against the dark cta-box -->
    <style>
        .home-enquiry-form { max-width: 600px; margin: 0 auto; text-align: left; }
        .home-enquiry-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .home-enquiry-field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .home-enquiry-row .home-enquiry-field { margin-bottom: 0; }
        .home-enquiry-field label { font-size: 0.75rem; font-weight: 700; color: rgba(255,255,255,0.75); text-transform: uppercase; letter-spacing: 0.5px; }
        .home-enquiry-field input, .home-enquiry-field select, .home-enquiry-field textarea {
            padding: 13px 14px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.15);
            font-size: 0.95rem; outline: none; background: rgba(255,255,255,0.06); color: #fff;
            width: 100%; font-family: inherit; resize: vertical; transition: var(--transition-smooth);
        }
        .home-enquiry-field select { cursor: pointer; }
        .home-enquiry-field select option { background: var(--navy); color: #fff; }
        .home-enquiry-field input::placeholder, .home-enquiry-field textarea::placeholder { color: rgba(255,255,255,0.4); }
        .home-enquiry-field input:focus, .home-enquiry-field select:focus, .home-enquiry-field textarea:focus {
            border-color: var(--cyan-neon); background: rgba(255,255,255,0.1);
            box-shadow: 0 0 0 4px rgba(0, 242, 254, 0.12);
        }
        .home-enquiry-privacy { font-size: 0.8rem; color: rgba(255,255,255,0.55); margin-bottom: 20px; }
        .home-enquiry-privacy a { color: var(--cyan-neon); text-decoration: none; }
        .home-enquiry-privacy a:hover { text-decoration: underline; }
        @media (max-width: 576px) {
            .home-enquiry-row { grid-template-columns: 1fr; gap: 16px; }
        }
    </style>

<?php include 'footer.php'; ?>