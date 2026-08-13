<!-- PREMIUM FOOTER -->
    <style>
        footer { 
            background: linear-gradient(to bottom, #0B0F25, #050814) !important; 
            color: #fff !important; padding: 100px 0 30px !important; border-top: 1px solid rgba(0, 242, 254, 0.2) !important; position: relative !important; overflow: hidden !important; width: 100% !important; display: block !important;
        }
        footer::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 1px; background: linear-gradient(90deg, transparent, var(--cyan-neon), transparent); }
        
        .footer-logo { height: auto !important; margin-bottom: 25px !important; display: inline-flex !important; }
        .footer-grid { display: grid !important; grid-template-columns: 2fr 1fr 1fr 1.5fr !important; gap: clamp(30px, 4vw, 50px) !important; width: 100% !important; }
        
        .footer-brand p { color: rgba(255,255,255,0.6) !important; line-height: 1.7 !important; max-width: 320px !important; font-size: 0.95rem !important; }
        .footer-heading { font-size: 1.1rem !important; font-weight: 700 !important; color: #fff !important; margin-bottom: 25px !important; text-transform: uppercase !important; letter-spacing: 1px !important; }
        
        .footer-links { list-style: none !important; padding: 0 !important; margin: 0 !important; }
        .footer-links li { margin-bottom: 16px !important; }
        .footer-links a { color: rgba(255,255,255,0.6) !important; text-decoration: none !important; transition: var(--transition-smooth) !important; display: inline-block !important; font-size: 0.95rem !important; }
        .footer-links a:hover { color: var(--cyan-neon) !important; transform: translateX(5px) !important; }
        
        .footer-contact { list-style: none !important; padding: 0 !important; margin: 0 !important; }
        .footer-contact li { display: flex !important; align-items: flex-start !important; gap: 15px !important; color: rgba(255,255,255,0.7) !important; margin-bottom: 18px !important; font-size: 0.95rem !important; line-height: 1.5 !important; word-break: break-word !important; }
        .footer-contact i { color: var(--cyan-neon) !important; font-size: 1.1rem !important; background: rgba(0, 242, 254, 0.05) !important; width: 35px !important; height: 35px !important; display: flex !important; align-items: center !important; justify-content: center !important; border-radius: 50% !important; flex-shrink: 0 !important; border: 1px solid rgba(0, 242, 254, 0.1) !important; }
        
        .social-links { display: flex !important; gap: 15px !important; margin-top: 25px !important; }
        .social-links a { width: 40px !important; height: 40px !important; border-radius: 50% !important; background: rgba(255,255,255,0.05) !important; border: 1px solid rgba(255,255,255,0.1) !important; display: flex !important; align-items: center !important; justify-content: center !important; color: #fff !important; transition: var(--transition-smooth) !important; text-decoration: none !important; font-size: 1rem !important; }
        .social-links a:hover { background: var(--cyan-neon) !important; color: var(--navy) !important; transform: translateY(-3px) !important; box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3) !important; }
        
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1) !important; margin-top: 80px !important; padding-top: 30px !important; display: flex !important; justify-content: space-between !important; align-items: center !important; color: rgba(255,255,255,0.5) !important; font-size: 0.9rem !important; flex-wrap: wrap !important; gap: 20px !important;}

        @media(max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr 1fr !important; gap: 50px !important; }
            .footer-brand p { max-width: 100% !important; } 
        }

        @media(max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr !important; text-align: center !important; gap: 40px !important; }
            .footer-logo { justify-content: center !important; margin: 0 auto 20px !important; display: flex !important; height: auto !important; }
            .footer-brand p { margin: 0 auto !important; text-align: center !important; max-width: 400px !important; }
            .social-links { justify-content: center !important; }
            .footer-contact li { flex-direction: column !important; align-items: center !important; text-align: center !important; gap: 10px !important; }
            .footer-bottom { flex-direction: column !important; text-align: center !important; gap: 15px !important; }
            .footer-bottom div { justify-content: center !important; width: 100% !important; }
        }
    </style>

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
                        <li><a href="services.php#seo">Search Engine Optimization</a></li>
                        <li><a href="services.php#ecom">E-commerce</a></li>
                        <li><a href="services.php#web">Website Development</a></li>
                        <li><a href="services.php#social">Social Media</a></li>
                        <li><a href="services.php#ppc">PPC Advertising</a></li>
                        <li><a href="services.php#graphic">Graphic Design</a></li>
                        <li><a href="services.php#content">Content Writing</a></li>
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

    <!-- SCRIPTS -->
    <script>
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }

        document.addEventListener("DOMContentLoaded", () => {
            gsap.registerPlugin(ScrollTrigger);

            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            let mm = gsap.matchMedia();

            mm.add("(min-width: 769px)", () => {
                gsap.set(".laptop-container", { xPercent: -50, yPercent: 0 });
                gsap.set(".mobile-container", { xPercent: -50, yPercent: -50, scale: 1 });
                gsap.set(".scatter-item", { xPercent: -50, yPercent: -50, opacity: 1, scale: 1 });
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
                    duration: 1, 
                    ease: "power2.out"
                }, 0);

                masterTl.to(".serp-screen", { y: "-55%", duration: 1.5, ease: "none" }, 0.5);
                masterTl.to(".serp-screen", { opacity: 0, duration: 0.2 }, 2.0);
                masterTl.to(".logo-screen", { opacity: 1, duration: 0.3 }, 2.2);
                masterTl.to(".scatter-item", { opacity: 0, scale: 0.8, duration: 0.3 }, 2.0);

                masterTl.to(".laptop-container", { yPercent: 0, opacity: 1, duration: 2, ease: "power3.inOut" }, 2.5); 
                masterTl.to(".mobile-container", { left: "86%", top: "70%", scale: 0.35, boxShadow: "0 20px 40px rgba(0,0,0,0.5)", duration: 2, ease: "power3.inOut" }, 2.5); 
                masterTl.to(".stage-header", { opacity: 1, y: 0, duration: 0.8, ease: "power2.out" }, 3.0);
                
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

            // === PREMIUM SITE-WIDE ENTRANCE ANIMATIONS ===
            // Everything below is purely decorative motion, so it's skipped
            // entirely for users who've asked for reduced motion.
            if (prefersReducedMotion) {
                gsap.set('.fade-up, .hero .fade-up', { opacity: 1, y: 0, x: 0 });
                return;
            }

            gsap.fromTo('header', { y: -80, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' });

            // Hero copy plays immediately as a staggered sequence rather than
            // each line fading in independently at the same instant.
            const heroEls = gsap.utils.toArray('.hero .fade-up');
            if (heroEls.length) {
                gsap.fromTo(heroEls, { opacity: 0, y: 30 }, {
                    opacity: 1, y: 0, duration: 0.7, stagger: 0.14, ease: 'power2.out', delay: 0.15
                });
            }

            // Every other .fade-up (section wrappers, CTA boxes, footer columns)
            // reveals as the user scrolls to it.
            gsap.utils.toArray('.fade-up').forEach(element => {
                if (heroEls.includes(element)) return;
                gsap.fromTo(element,
                    { opacity: 0, y: 40 },
                    { opacity: 1, y: 0, duration: 0.6, ease: "power2.out",
                      scrollTrigger: { trigger: element, start: "top 85%", toggleActions: "play none none none" }
                    }
                );
            });

            // Every card/list inside these grids gets its own scroll-triggered
            // reveal (rather than one trigger for the whole grid) so long grids
            // like the case studies page still animate correctly row by row.
            const gridSelectors = [
                '.services-grid', '.case-grid', '.testimonials-grid', '.industry-tile-grid',
                '.stats-4-grid', '.pricing-grid', '.methodology-steps', '.agency-list',
                '.cta-features', '.faq-list', '.mobile-dash-cards', '.partner-strip'
            ];
            gridSelectors.forEach(selector => {
                gsap.utils.toArray(selector).forEach(grid => {
                    const items = gsap.utils.toArray(grid.children);
                    items.forEach((item, i) => {
                        gsap.fromTo(item, { opacity: 0, y: 34 }, {
                            opacity: 1, y: 0, duration: 0.55, delay: (i % 3) * 0.08, ease: 'power2.out',
                            scrollTrigger: { trigger: item, start: 'top 90%', toggleActions: 'play none none none' }
                        });
                    });
                });
            });

            // Two-column image/text sections slide in from opposite sides.
            gsap.utils.toArray('.agency-grid, .methodology-grid').forEach(grid => {
                const media = grid.querySelector('.agency-image-wrapper, .methodology-image');
                const copy = grid.querySelector('.agency-text, .methodology-steps');
                const trigger = { trigger: grid, start: 'top 82%', toggleActions: 'play none none none' };
                if (media) gsap.fromTo(media, { opacity: 0, x: -50 }, { opacity: 1, x: 0, duration: 0.8, ease: 'power2.out', scrollTrigger: trigger });
                if (copy) gsap.fromTo(copy, { opacity: 0, x: 50 }, { opacity: 1, x: 0, duration: 0.8, ease: 'power2.out', scrollTrigger: trigger });
            });

            // Stat numbers count up from zero once they scroll into view.
            gsap.utils.toArray('.stat-box h3').forEach(el => {
                const text = el.textContent.trim();
                const match = text.match(/^([^0-9\-]*)(-?[0-9.,]+)(.*)$/);
                if (!match) return;
                const [, prefix, rawNum, suffix] = match;
                const cleanNum = rawNum.replace(/,/g, '');
                const target = parseFloat(cleanNum);
                if (isNaN(target)) return;
                const decimals = (cleanNum.split('.')[1] || '').length;
                const counter = { val: 0 };
                ScrollTrigger.create({
                    trigger: el, start: 'top 88%', once: true,
                    onEnter: () => {
                        gsap.to(counter, {
                            val: target, duration: 1.5, ease: 'power2.out',
                            onUpdate: () => { el.textContent = prefix + counter.val.toFixed(decimals) + suffix; }
                        });
                    }
                });
            });
        });
    </script>

    <!-- 3D ANIMATED HERO BACKGROUND (Three.js) -->
    <script>
        (function () {
            const hero = document.querySelector('.hero');
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (!hero || typeof THREE === 'undefined' || prefersReducedMotion) return;

            const canvas = document.createElement('canvas');
            canvas.id = 'hero-3d-canvas';
            hero.insertBefore(canvas, hero.firstChild);

            const isMobile = window.innerWidth <= 768;
            const particleCount = isMobile ? 45 : 110;
            const linkDistance = isMobile ? 16 : 20;

            const renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true });
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(55, 1, 0.1, 200);
            camera.position.z = 60;

            const group = new THREE.Group();
            scene.add(group);

            // Scatter particles inside a wide, flat volume so the network reads
            // as a horizontal band behind the hero copy rather than a dense ball.
            const colorA = new THREE.Color(0x00F2FE);
            const colorB = new THREE.Color(0xFF007F);
            const positions = new Float32Array(particleCount * 3);
            const colors = new Float32Array(particleCount * 3);
            const points = [];

            for (let i = 0; i < particleCount; i++) {
                const x = (Math.random() - 0.5) * 110;
                const y = (Math.random() - 0.5) * 55;
                const z = (Math.random() - 0.5) * 50;
                positions[i * 3] = x;
                positions[i * 3 + 1] = y;
                positions[i * 3 + 2] = z;
                points.push(new THREE.Vector3(x, y, z));

                const mixed = colorA.clone().lerp(colorB, Math.random());
                colors[i * 3] = mixed.r;
                colors[i * 3 + 1] = mixed.g;
                colors[i * 3 + 2] = mixed.b;
            }

            const particleGeometry = new THREE.BufferGeometry();
            particleGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            particleGeometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));

            const particleMaterial = new THREE.PointsMaterial({
                size: isMobile ? 1.1 : 1.4,
                vertexColors: true,
                transparent: true,
                opacity: 0.85,
                sizeAttenuation: true
            });
            group.add(new THREE.Points(particleGeometry, particleMaterial));

            // Connect nearby particles once; the whole group rotates rigidly
            // afterwards so we never need to recompute the network.
            const linePositions = [];
            const lineColors = [];
            const maxLines = isMobile ? 60 : 160;
            let lineCount = 0;
            for (let i = 0; i < points.length && lineCount < maxLines; i++) {
                for (let j = i + 1; j < points.length && lineCount < maxLines; j++) {
                    if (points[i].distanceTo(points[j]) < linkDistance) {
                        linePositions.push(points[i].x, points[i].y, points[i].z, points[j].x, points[j].y, points[j].z);
                        const c = colorA.clone().lerp(colorB, 0.5);
                        lineColors.push(c.r, c.g, c.b, c.r, c.g, c.b);
                        lineCount++;
                    }
                }
            }

            const lineGeometry = new THREE.BufferGeometry();
            lineGeometry.setAttribute('position', new THREE.Float32BufferAttribute(linePositions, 3));
            lineGeometry.setAttribute('color', new THREE.Float32BufferAttribute(lineColors, 3));
            const lineMaterial = new THREE.LineBasicMaterial({ vertexColors: true, transparent: true, opacity: 0.18 });
            group.add(new THREE.LineSegments(lineGeometry, lineMaterial));

            let targetRotX = 0, targetRotY = 0;
            window.addEventListener('mousemove', (e) => {
                targetRotY = ((e.clientX / window.innerWidth) - 0.5) * 0.5;
                targetRotX = ((e.clientY / window.innerHeight) - 0.5) * 0.3;
            }, { passive: true });

            function resize() {
                const w = hero.clientWidth;
                const h = hero.clientHeight;
                if (!w || !h) return;
                renderer.setSize(w, h, false);
                camera.aspect = w / h;
                camera.updateProjectionMatrix();
            }
            resize();
            window.addEventListener('resize', resize);

            let isVisible = true;
            if ('IntersectionObserver' in window) {
                new IntersectionObserver((entries) => {
                    isVisible = entries[0].isIntersecting;
                }, { threshold: 0.05 }).observe(hero);
            }

            let rafId = null;
            let readyFlagged = false;
            function animate() {
                rafId = requestAnimationFrame(animate);
                if (document.hidden || !isVisible) return;

                group.rotation.y += 0.0012;
                group.rotation.x += (targetRotX - group.rotation.x) * 0.03;
                group.rotation.y += (targetRotY - group.rotation.y) * 0.02;

                renderer.render(scene, camera);

                if (!readyFlagged) {
                    canvas.classList.add('is-ready');
                    readyFlagged = true;
                }
            }
            animate();
        })();
    </script>
</body>
</html>