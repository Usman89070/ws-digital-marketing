<!-- PREMIUM FOOTER -->
    <style>
        footer {
            background: linear-gradient(to bottom, #0B0F25, #050814);
            color: #fff; padding: 100px 0 30px; border-top: 1px solid rgba(0, 242, 254, 0.2); position: relative; overflow: hidden; width: 100%; display: block;
        }
        footer::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 1px; background: linear-gradient(90deg, transparent, var(--cyan-neon), transparent); }

        .footer-logo { height: auto; margin-bottom: 25px; display: inline-flex; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: clamp(30px, 4vw, 50px); width: 100%; }

        .footer-brand p { color: rgba(255,255,255,0.6); line-height: 1.7; max-width: 320px; font-size: 0.95rem; }
        .footer-heading { font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 1px; }

        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 16px; }
        .footer-links a { color: rgba(255,255,255,0.6); text-decoration: none; transition: var(--transition-smooth); display: inline-block; font-size: 0.95rem; }
        .footer-links a:hover { color: var(--cyan-neon); transform: translateX(5px); }

        .footer-contact { list-style: none; padding: 0; margin: 0; }
        .footer-contact li { display: flex; align-items: flex-start; gap: 15px; color: rgba(255,255,255,0.7); margin-bottom: 18px; font-size: 0.95rem; line-height: 1.5; word-break: break-word; }
        .footer-contact i { color: var(--cyan-neon); font-size: 1.1rem; background: rgba(0, 242, 254, 0.05); width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; flex-shrink: 0; border: 1px solid rgba(0, 242, 254, 0.1); }

        .social-links { display: flex; gap: 15px; margin-top: 25px; }
        .social-links a { width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #fff; transition: var(--transition-smooth); text-decoration: none; font-size: 1rem; }
        .social-links a:hover { background: var(--cyan-neon); color: var(--navy); transform: translateY(-3px) rotate(-8deg); box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3); }

        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); margin-top: 80px; padding-top: 30px; display: flex; justify-content: space-between; align-items: center; color: rgba(255,255,255,0.5); font-size: 0.9rem; flex-wrap: wrap; gap: 20px; }

        .back-to-top { width: 42px; height: 42px; border-radius: 50%; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.15); color: #fff; cursor: pointer; transition: transform 0.3s var(--ease-spring), background 0.3s; }
        .back-to-top:hover { background: var(--cyan-neon); color: var(--navy); transform: translateY(-4px); }

        @media(max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 50px; }
            .footer-brand p { max-width: 100%; }
        }

        @media(max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr; text-align: center; gap: 40px; }
            .footer-logo { justify-content: center; margin: 0 auto 20px; display: flex; height: auto; }
            .footer-brand p { margin: 0 auto; text-align: center; max-width: 400px; }
            .social-links { justify-content: center; }
            .footer-contact li { flex-direction: column; align-items: center; text-align: center; gap: 10px; }
            .footer-bottom { flex-direction: column; text-align: center; gap: 15px; }
            .footer-bottom div { justify-content: center; width: 100%; }
        }
    </style>

    <footer>
        <div class="container">
            <div class="footer-grid fade-up">
                <!-- Brand Col -->
                <div class="footer-brand">
                    <a href="index.php" class="logo footer-logo">
                        <img src="images/logo-ws.svg" alt="W&S Digital Marketing Logo" class="logo-img" style="filter: brightness(0) invert(1);">
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
                        <li><a href="services.php">Services</a></li>
                        <li><a href="index.php#case-studies">Case Studies</a></li>
                        <li><a href="index.php#contact">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="footer-heading">Services</h4>
                    <ul class="footer-links">
                        <li><a href="services.php#seo">Search Engine Optimization</a></li>
                        <li><a href="services.php#ecom">E-commerce</a></li>
                        <li><a href="services.php#web">Website Development</a></li>
                        <li><a href="services.php#social">Social Media & PPC</a></li>
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

            <div class="footer-bottom fade-up">
                <p>© 2026 W&S Digital Marketing. All Rights Reserved.</p>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <a href="#" style="color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.3s;">Privacy Policy</a>
                    <a href="#" style="color: rgba(255,255,255,0.5); text-decoration: none; transition: color 0.3s;">Terms of Service</a>
                    <button id="backToTop" class="back-to-top" aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></button>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script>
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* --- Sticky header + scroll progress bar --- */
        var siteHeader = document.querySelector('header');
        var scrollProgress = document.getElementById('scrollProgress');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                siteHeader.classList.add('scrolled');
            } else {
                siteHeader.classList.remove('scrolled');
            }
            if (scrollProgress) {
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const pct = docHeight > 0 ? (window.scrollY / docHeight) * 100 : 0;
                scrollProgress.style.width = pct + '%';
            }
        }, { passive: true });

        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }

        /* --- Back to top --- */
        const backToTop = document.getElementById('backToTop');
        if (backToTop) {
            backToTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            gsap.registerPlugin(ScrollTrigger);

            let mm = gsap.matchMedia();

            mm.add("(min-width: 769px)", () => {
                gsap.set(".laptop-container", { xPercent: -50, yPercent: 0, rotationX: 22, rotationY: -20, rotationZ: 1, transformPerspective: 1400, transformOrigin: "center bottom" });
                gsap.set(".mobile-container", { xPercent: -50, yPercent: -50, scale: 1, rotationX: 10, rotationY: 18, rotationZ: -4, transformPerspective: 1200 });
                gsap.set(".scatter-item", { xPercent: -50, yPercent: -50, opacity: 1, scale: 1, rotationX: 6, rotationY: -6, transformPerspective: 900 });
                gsap.set(".stage-header", { opacity: 0, y: -20 });

                let masterTl = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".cinematic-wrapper",
                        start: "top 80px",
                        end: "+=3500",
                        pin: true,
                        scrub: 1
                    }
                });

                masterTl.to(".scatter-item", {
                    x: (index) => (index % 2 === 0) ? -250 : 250,
                    y: (index) => (index < 2) ? -150 : 150,
                    rotationX: 0,
                    rotationY: 0,
                    duration: 1,
                    ease: "power2.out"
                }, 0);

                masterTl.to(".serp-screen", { y: "-55%", duration: 1.5, ease: "none" }, 0.5);
                masterTl.to(".serp-screen", { opacity: 0, duration: 0.2 }, 2.0);
                masterTl.to(".logo-screen", { opacity: 1, duration: 0.3 }, 2.2);
                masterTl.to(".scatter-item", { opacity: 0, scale: 0.8, duration: 0.3 }, 2.0);

                masterTl.to(".laptop-container", { yPercent: 0, opacity: 1, rotationX: 8, rotationY: -8, duration: 2, ease: "power3.inOut" }, 2.5);
                masterTl.to(".mobile-container", { left: "86%", top: "70%", scale: 0.35, rotationX: 4, rotationY: 6, rotationZ: -2, boxShadow: "0 20px 40px rgba(0,0,0,0.5)", duration: 2, ease: "power3.inOut" }, 2.5);
                masterTl.to(".stage-header", { opacity: 1, y: 0, duration: 0.8, ease: "power2.out" }, 3.0);

                /* Subtle idle 3D drift once docked, purely decorative */
                if (!reduceMotion) {
                    gsap.to(".laptop-container", {
                        rotationY: "-=3", rotationX: "+=1.5", duration: 4, ease: "sine.inOut",
                        repeat: -1, yoyo: true, delay: 4
                    });
                }

                return () => {};
            });

            mm.add("(max-width: 768px)", () => {
                gsap.set(".stage-header", { opacity: 1, y: 0 });
                gsap.set(".serp-screen", { y: "0%", opacity: 1 });
                gsap.set(".logo-screen", { opacity: 0 });

                let mobileTl = gsap.timeline({
                    scrollTrigger: {
                        trigger: ".cinematic-wrapper",
                        start: "top 85px",
                        end: "+=800",
                        pin: true,
                        scrub: 1
                    }
                });

                mobileTl.to(".serp-screen", { y: "-55%", duration: 2, ease: "none" });
                mobileTl.to(".serp-screen", { opacity: 0, duration: 0.3 });
                mobileTl.to(".logo-screen", { opacity: 1, duration: 0.5 });

                return () => {};
            });

            gsap.utils.toArray('.fade-up').forEach(element => {
                gsap.fromTo(element,
                    { opacity: 0, y: 40 },
                    { opacity: 1, y: 0, duration: 0.6, ease: "power2.out",
                      scrollTrigger: { trigger: element, start: "top 85%", toggleActions: "play none none none" }
                    }
                );
            });

            /* --- Staggered card reveals for grid sections (replaces a single
                 whole-section fade so each card animates in individually) --- */
            [
                { grid: ".services-grid", item: ".service-card" },
                { grid: ".testimonials-grid", item: ".testi-card" },
                { grid: ".industries-grid", item: ".industry-card" },
                { grid: ".methodology-steps", item: ".m-step" }
            ].forEach(({ grid, item }) => {
                const container = document.querySelector(grid);
                if (!container) return;
                gsap.fromTo(container.querySelectorAll(item),
                    { opacity: 0, y: 40 },
                    { opacity: 1, y: 0, duration: 0.6, ease: "power2.out", stagger: 0.12,
                      scrollTrigger: { trigger: container, start: "top 85%", toggleActions: "play none none none" }
                    }
                );
            });

            /* --- Reveal the dashboard chart (bars + line) and count up the stats
                 once the cinematic stage scrolls into view --- */
            ScrollTrigger.create({
                trigger: ".cinematic-wrapper",
                start: "top 80%",
                once: true,
                onEnter: () => {
                    document.querySelector(".devices-stage").classList.add("stage-in-view");
                    countUpAll(document.querySelectorAll(
                        ".scatter-item .val, .dash-card-value"
                    ));
                }
            });

            document.querySelectorAll(".mobile-perf-overview .m-dash-card-value").forEach((el) => {
                ScrollTrigger.create({
                    trigger: el,
                    start: "top 90%",
                    once: true,
                    onEnter: () => countUpAll([el])
                });
            });
        });

        /* ---------------------------------------------------------------------
           Count-up stat numbers (handles trailing icons like "135 <i>...</i>")
           ------------------------------------------------------------------- */
        function countUpAll(elements) {
            elements.forEach((el) => {
                const firstNode = el.childNodes[0];
                const raw = (firstNode && firstNode.nodeType === Node.TEXT_NODE) ? firstNode.textContent : el.textContent;
                const match = raw.trim().match(/^([\d.]+)(.*)$/);
                if (!match) return;

                const target = parseFloat(match[1]);
                const suffix = match[2] || '';
                const decimals = match[1].indexOf('.') > -1 ? match[1].split('.')[1].length : 0;

                const countNode = document.createElement('span');
                countNode.textContent = '0' + suffix;

                if (firstNode && firstNode.nodeType === Node.TEXT_NODE) {
                    el.replaceChild(countNode, firstNode);
                } else {
                    el.textContent = '';
                    el.appendChild(countNode);
                }

                if (reduceMotion) {
                    countNode.textContent = target.toFixed(decimals) + suffix;
                    return;
                }

                const duration = 1400;
                let startTime = null;
                function step(ts) {
                    if (!startTime) startTime = ts;
                    const progress = Math.min((ts - startTime) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    countNode.textContent = (target * eased).toFixed(decimals) + suffix;
                    if (progress < 1) requestAnimationFrame(step);
                    else countNode.textContent = target.toFixed(decimals) + suffix;
                }
                requestAnimationFrame(step);
            });
        }

        /* ---------------------------------------------------------------------
           3D tilt-on-hover for grid cards (independent of the GSAP-pinned stage)
           ------------------------------------------------------------------- */
        function applyCardTilt(selector, maxDeg) {
            if (reduceMotion || !window.matchMedia('(hover: hover)').matches) return;

            document.querySelectorAll(selector).forEach((card) => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const px = (e.clientX - rect.left) / rect.width - 0.5;
                    const py = (e.clientY - rect.top) / rect.height - 0.5;
                    card.style.transform = `perspective(900px) rotateX(${(-py * maxDeg).toFixed(2)}deg) rotateY(${(px * maxDeg).toFixed(2)}deg) translateY(-6px)`;
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(900px) rotateX(0deg) rotateY(0deg) translateY(0)';
                });
            });
        }

        applyCardTilt('.service-card', 8);
        applyCardTilt('.testi-card', 6);
        applyCardTilt('.industry-card', 10);
        applyCardTilt('.case-card', 8);
    </script>
</body>
</html>
