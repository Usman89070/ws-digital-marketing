<!-- PREMIUM FOOTER -->

    <footer>
        <div class="container">
            <div class="footer-grid fade-up">
                <!-- Brand Col -->
                <div class="footer-brand">
                    <a href="/" class="logo footer-logo">
                        <img src="/images/logo-ws.webp" alt="W&S Digital Marketing Logo" class="logo-img">
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
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/our-team">Our Team</a></li>
                        <li><a href="/services">Services</a></li>
                        <li><a href="/industries">Industries</a></li>
                        <li><a href="/case-studies">Case Studies</a></li>
                        <li><a href="/pricing">Pricing</a></li>
                        <li><a href="/blog">Blog</a></li>
                        <li><a href="/faq">FAQ</a></li>
                        <li><a href="/contact">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="footer-heading">Services</h4>
                    <ul class="footer-links">
                        <li><a href="/seo">Search Engine Optimization</a></li>
                        <li><a href="/ecommerce">E-commerce</a></li>
                        <li><a href="/website-development">Website Development</a></li>
                        <li><a href="/social-media">Social Media</a></li>
                        <li><a href="/ppc-advertising">PPC Advertising</a></li>
                        <li><a href="/graphic-design">Graphic Design</a></li>
                        <li><a href="/content-writing">Content Writing</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="footer-heading">Get In Touch</h4>
                    <ul class="footer-contact">
                        <li><i class="fa-solid fa-phone"></i> <span>1300 123 456</span></li>
                        <li><i class="fa-solid fa-envelope"></i> <span>info@wsdigitalmarketing.com.au</span></li>
                        <li><i class="fa-solid fa-location-dot"></i> <span>Level 32, Sydney, NSW 2000, Australia</span></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>© 2026 W&S Digital Marketing. All Rights Reserved.</p>
                <div style="display: flex; gap: 20px;">
                    <a href="/privacy-policy" style="color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.3s;">Privacy Policy</a>
                    <a href="/terms-of-service" style="color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.3s;">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <div id="scroll-progress"></div>
    <a href="https://wa.me/61403889630" target="_blank" rel="noopener noreferrer" id="whatsapp-chat" aria-label="Chat with us on WhatsApp" title="Chat with us on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
    <button id="back-to-top" aria-label="Back to top" title="Back to top"><i class="fa-solid fa-arrow-up"></i></button>

    <!-- Site JS: nav, scroll effects, GSAP animations, and stat counters -- loads and
         runs as soon as gsap/ScrollTrigger are ready, independent of Three.js below.
         .htaccess caches this file for a year as "immutable", so the ?v= query string
         (the file's own last-modified time) is what actually busts that cache on every
         real edit -- without it, visitors who already loaded the site once would keep
         running the old JS for a full year no matter how many fixes get shipped. -->
    <script src="/js/main.js?v=<?php echo @filemtime(__DIR__ . '/js/main.js') ?: time(); ?>" defer></script>

    <!-- Three.js + the background wallpaper animation are the heaviest, least
         time-critical piece of the page (~600KB, purely decorative), so rather than
         even queuing them as defer scripts -- which still download during initial
         load and compete for bandwidth with everything that actually matters for
         paint/interactivity metrics -- their <script> tags aren't injected until
         AFTER the window "load" event, deferred further still to an idle callback
         where supported. Nothing about the visible effect changes: the canvas
         already fades in via its own opacity transition once ready, so starting
         that fetch a little later is invisible to visitors but keeps this ~600KB
         library completely off the critical path Lighthouse/Core Web Vitals score. -->
    <script>
        window.addEventListener('load', function () {
            function loadBackground() {
                var three = document.createElement('script');
                three.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js';
                three.onload = function () {
                    var bg = document.createElement('script');
                    bg.src = '/js/bg-animation.js?v=<?php echo @filemtime(__DIR__ . '/js/bg-animation.js') ?: time(); ?>';
                    document.body.appendChild(bg);
                };
                document.body.appendChild(three);
            }
            if ('requestIdleCallback' in window) {
                requestIdleCallback(loadBackground, { timeout: 2000 });
            } else {
                setTimeout(loadBackground, 200);
            }
        });
    </script>
</body>
</html>