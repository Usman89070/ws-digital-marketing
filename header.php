<?php
// Pages can set these before including this file; sensible defaults otherwise.
$page_title = $page_title ?? 'Premium Agency';
$page_description = $page_description ?? 'Data-driven Google Ads, Meta Ads, SEO and web design strategies that generate high-intent leads, sales, and revenue for ambitious Australian businesses.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8'); ?> | W&amp;S Digital Marketing</title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description, ENT_QUOTES, 'UTF-8'); ?>">

    <!-- Connect early to third-party origins so the real requests below don't pay the
         DNS+TLS handshake cost later in the load -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://images.unsplash.com">

    <!-- The logo renders immediately (splash screen + header on every page) -->
    <link rel="preload" as="image" href="images/logo-ws.webp" fetchpriority="high">

    <!-- Site CSS: one external, browser-cached file shared by every page instead of a
         ~20KB inline block repeated on each request. .htaccess caches this file for a
         year as "immutable", so the ?v= query string (the file's own last-modified
         time) is what actually busts that cache on every real edit -- without it,
         visitors who already loaded the site once would keep serving the old CSS for
         a full year no matter how many fixes get shipped. -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo @filemtime(__DIR__ . '/css/style.css') ?: time(); ?>">

    <!-- GSAP / ScrollTrigger: deferred so they never block HTML parsing or first paint.
         Deferred scripts execute in strict source order before DOMContentLoaded, so
         js/main.js (loaded right after these, at the end of the page) can safely
         assume gsap/ScrollTrigger are ready. Three.js is intentionally NOT loaded here
         -- see footer.php for why -- it's ~600KB and only needed by the decorative
         background, so it must not sit in front of main.js in the defer queue or the
         header/nav toggle would have to wait for it to finish downloading first. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js" defer></script>

    <!-- FontAwesome: loaded non-render-blocking (fetched with the preload's priority,
         applied once ready) since icons are decorative and shouldn't hold up first paint -->
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"></noscript>

    <!-- Google Fonts (already using font-display: swap so text never waits on it) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

</head>
<body>

    <!-- SPLASH SCREEN: plays on every page load/navigation and on refresh -->
    <div id="splash-screen" aria-hidden="true">
        <img src="images/logo-ws.webp" alt="" class="splash-logo">
        <div class="splash-bar"></div>
    </div>

    <!-- HEADER (Solid Dark Theme, No Blur) -->
    <header>
        <div class="container nav-wrapper">
            <a href="index.php" class="logo" style="display: flex; align-items: center;">
                <img src="images/logo-ws.webp" alt="W&S Digital Marketing Logo" class="logo-img">
            </a>
            
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="index.php" onclick="toggleMenu()">Home</a></li>
                    <li><a href="about.php" onclick="toggleMenu()">About Us</a></li>
                    
                    <!-- SERVICES DROPDOWN -->
                    <li class="dropdown" onclick="toggleDropdown(event)">
                        <a href="services.php">Services <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; margin-left: 4px;"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="services.php" class="dropdown-hub-link">All Services</a></li>
                            <li><a href="seo.php">Search Engine Optimization</a></li>
                            <li><a href="ecommerce.php">E-commerce</a></li>
                            <li><a href="website-development.php">Website Development & Design</a></li>
                            <li><a href="social-media.php">Social Media</a></li>
                            <li><a href="ppc-advertising.php">PPC Advertising</a></li>
                            <li><a href="graphic-design.php">Graphic Design</a></li>
                            <li><a href="content-writing.php">Content Writing</a></li>
                        </ul>
                    </li>

                    <li><a href="case-studies.php" onclick="toggleMenu()">Case Studies</a></li>
                    
                    <!-- AGENCY DROPDOWN -->
                    <li class="dropdown" onclick="toggleDropdown(event)">
                        <a href="about.php">Agency <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; margin-left: 4px;"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="our-team.php">Our Team</a></li>
                            <li><a href="reviews.php">Reviews</a></li>
                            <li><a href="blog.php">Blog</a></li>
                            <li><a href="pricing.php">Pricing Plans</a></li>
                            <li><a href="faq.php">FAQ</a></li>
                        </ul>
                    </li>

                    <!-- INDUSTRIES DROPDOWN -->
                    <li class="dropdown" onclick="toggleDropdown(event)">
                        <a href="industries.php">Industries <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; margin-left: 4px;"></i></a>
                        <ul class="dropdown-menu dropdown-menu-grid">
                            <li><a href="industries.php" class="dropdown-hub-link">All Industries</a></li>
                            <li><a href="accounting-finance.php">Accounting & Finance</a></li>
                            <li><a href="automotive.php">Automotive</a></li>
                            <li><a href="construction-building.php">Construction & Building</a></li>
                            <li><a href="dental.php">Dental</a></li>
                            <li><a href="ecommerce-industry.php">eCommerce</a></li>
                            <li><a href="franchise.php">Franchise</a></li>
                            <li><a href="healthcare-medical.php">Healthcare & Medical</a></li>
                            <li><a href="hospitality-tourism.php">Hospitality & Tourism</a></li>
                            <li><a href="hotel-motel.php">Hotel & Motel</a></li>
                            <li><a href="legal-law.php">Legal / Law</a></li>
                            <li><a href="real-estate.php">Real Estate</a></li>
                            <li><a href="small-business-digital-marketing.php">Small Business Digital Marketing</a></li>
                            <li><a href="ndis.php">NDIS</a></li>
                            <li><a href="trades.php">Trades</a></li>
                        </ul>
                    </li>
                    <li><a href="contact.php" onclick="toggleMenu()">Contact Us</a></li>
                </ul>
                <div class="nav-roll-edge" id="navRollEdge" aria-hidden="true"></div>
            </nav>
            <div class="nav-cta">
                <a href="contact.php" class="header-cta">GET FREE PLAN</a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button class="mobile-btn" onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></button>
        </div>
    </header>