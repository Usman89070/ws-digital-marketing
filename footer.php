<!-- PREMIUM FOOTER -->

    <footer>
        <div class="container">
            <div class="footer-grid fade-up">
                <!-- Brand Col -->
                <div class="footer-brand">
                    <a href="index.php" class="logo footer-logo">
                        <img src="images/logo-ws.webp" alt="W&S Digital Marketing Logo" class="logo-img">
                    </a>
                    <p>
                        Helping ambitious Australian businesses confidently grow online with data-driven strategies that consistently deliver real results.
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="footer-heading">Company</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="our-team.php">Our Team</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="industries.php">Industries</a></li>
                        <li><a href="case-studies.php">Case Studies</a></li>
                        <li><a href="pricing.php">Pricing</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="footer-heading">Services</h4>
                    <ul class="footer-links">
                        <li><a href="seo.php">Search Engine Optimization</a></li>
                        <li><a href="ecommerce.php">E-commerce</a></li>
                        <li><a href="website-development.php">Website Development</a></li>
                        <li><a href="social-media.php">Social Media</a></li>
                        <li><a href="ppc-advertising.php">PPC Advertising</a></li>
                        <li><a href="graphic-design.php">Graphic Design</a></li>
                        <li><a href="content-writing.php">Content Writing</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="footer-heading">Get In Touch</h4>
                    <ul class="footer-contact">
                        <li><i class="fa-solid fa-phone"></i> <span>1300 123 456</span></li>
                        <li><i class="fa-solid fa-envelope"></i> <span>info@wsdigital.com.au</span></li>
                        <li><i class="fa-solid fa-location-dot"></i> <span>Level 32, Sydney, NSW 2000, Australia</span></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>© 2026 W&S Digital Marketing. All Rights Reserved.</p>
                <div style="display: flex; gap: 20px;">
                    <a href="privacy-policy.php" style="color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.3s;">Privacy Policy</a>
                    <a href="terms-of-service.php" style="color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.3s;">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <div id="scroll-progress"></div>
    <button id="back-to-top" aria-label="Back to top" title="Back to top"><i class="fa-solid fa-arrow-up"></i></button>

    <!-- Site JS: nav, scroll effects, GSAP animations, and stat counters -- loads and
         runs as soon as gsap/ScrollTrigger are ready, independent of Three.js below.
         .htaccess caches this file for a year as "immutable", so the ?v= query string
         (the file's own last-modified time) is what actually busts that cache on every
         real edit -- without it, visitors who already loaded the site once would keep
         running the old JS for a full year no matter how many fixes get shipped. -->
    <script src="js/main.js?v=<?php echo @filemtime(__DIR__ . '/js/main.js') ?: time(); ?>" defer></script>

    <!-- Three.js + the background wallpaper animation load after main.js in the defer
         queue on purpose: they're the heaviest, least time-critical piece (~600KB,
         purely decorative), so they must never be able to delay header/nav interactivity. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" defer></script>
    <script src="js/bg-animation.js?v=<?php echo @filemtime(__DIR__ . '/js/bg-animation.js') ?: time(); ?>" defer></script>
</body>
</html>