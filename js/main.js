// Site-wide JS: nav dropdown/toggle, scroll effects, GSAP animations, and
// stat counters. Loaded once via <script defer>, cached across every page.
// Deliberately does NOT depend on Three.js (see js/bg-animation.js) so the
// header/nav stay interactive even while that much heavier library is still
// downloading -- defer scripts execute strictly in document order, so if this
// file needed THREE it would have to wait for the whole 600KB+ library first.


// Clicking anywhere on a dropdown parent (Services/Agency/Industries) opens its
// submenu instead of following the link -- at every width, not just mobile. On
// desktop the submenu was already previewed on hover, so a click landed at the
// same moment hover had it open, making it look (and behave) like the click
// itself navigated away instantly with no chance to actually use the dropdown.
// The parent page itself stays reachable via an explicit "All Services"/
// "All Industries" link placed first inside the submenu (Agency skips this
// since "About Us" already covers it).
// The onclick lives on the <li>, so this also fires for clicks that bubble up
// from the submenu's own links -- those must be left alone to navigate normally,
// only a click on the parent label/chevron itself should toggle+prevent.
function toggleDropdown(e) {
    if (e.target.closest('.dropdown-menu')) return;
    e.preventDefault();
    e.currentTarget.classList.toggle('active');
}

// .active now keeps a dropdown's submenu visible independent of :hover (see the
// matching CSS rule), so on desktop a click-opened dropdown no longer auto-closes
// just because the pointer moves away. Close it explicitly on any click outside
// the dropdown itself, the standard "click outside to dismiss" pattern.
document.addEventListener('click', (e) => {
    if (e.target.closest('.dropdown')) return;
    document.querySelectorAll('.dropdown.active').forEach(d => d.classList.remove('active'));
});

// Team cards reveal their description/socials on :hover, which has no
// equivalent on touch -- there's no pointer to "move off of" to close it
// again, and no way to preview the reveal before deciding whether to tap a
// social link. On devices with no real hover, tap the card to toggle
// .tapped instead (closing any other open card first), same pattern as the
// dropdown above. A tap on a link inside the card (e.g. a social icon)
// still follows that link normally rather than just toggling the reveal.
if (window.matchMedia('(hover: none)').matches) {
    document.querySelectorAll('.team-card').forEach(card => {
        card.addEventListener('click', (e) => {
            if (e.target.closest('a')) return;
            const wasOpen = card.classList.contains('tapped');
            document.querySelectorAll('.team-card.tapped').forEach(c => c.classList.remove('tapped'));
            if (!wasOpen) card.classList.add('tapped');
        });
    });
    document.addEventListener('click', (e) => {
        if (e.target.closest('.team-card')) return;
        document.querySelectorAll('.team-card.tapped').forEach(c => c.classList.remove('tapped'));
    });
}

        const progressBar = document.getElementById('scroll-progress');
        const backToTopBtn = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            const scrollable = document.documentElement.scrollHeight - window.innerHeight;
            const progress = scrollable > 0 ? (window.scrollY / scrollable) * 100 : 0;
            if (progressBar) progressBar.style.width = progress + '%';

            if (backToTopBtn) backToTopBtn.classList.toggle('is-visible', window.scrollY > 600);
        }, { passive: true });

        if (backToTopBtn) {
            backToTopBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
            });
        }

        let navRollTween = null;
        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            const wrapEl = document.querySelector('.nav-wrapper');
            const rollEdge = document.getElementById('navRollEdge');
            const header = document.querySelector('header');
            const toggleIcon = document.querySelector('.mobile-btn i');
            const isOpening = !menu.classList.contains('active');
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const isToggleControlled = window.innerWidth <= 1200 || header.classList.contains('scrolled') || header.classList.contains('nav-open');

            if (toggleIcon) toggleIcon.className = isOpening ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
            if (navRollTween) navRollTween.kill();

            const finishClose = () => {
                menu.classList.remove('active');
                header.classList.remove('nav-open');
                // The carpet-roll animation above sets clip-path directly as an inline
                // style. At mobile/tablet widths the closed-state stylesheet rule
                // (@media max-width:1200px) sets the same value, so it's harmless -- but
                // at full desktop width nothing in the stylesheet governs clip-path at
                // all, since it's only ever meant to apply while the header is in its
                // scrolled/hamburger-driven state. Left in place, that stray inline value
                // (fully clipped) would keep clipping the nav-menu to invisible even after
                // scrolling back past the point where .scrolled is removed, permanently
                // hiding the whole desktop nav. Clearing it lets the current class/media
                // state (or lack of one) take back over cleanly.
                gsap.set(menu, { clearProps: 'clipPath' });
            };

            if (isOpening) {
                menu.classList.add('active');
                header.classList.add('nav-open');
            }

            if (!isToggleControlled || typeof gsap === 'undefined' || !wrapEl || !rollEdge) {
                if (!isOpening) finishClose();
                return;
            }

            if (prefersReducedMotion) {
                gsap.set(rollEdge, { autoAlpha: 0 });
                if (!isOpening) finishClose();
                return;
            }

            // Measure the dropdown panel relative to .nav-wrapper (the roll-edge's actual
            // positioning context, same as .nav-menu) so the "carpet" cylinder tracks its
            // real width/height at any breakpoint.
            const wrapRect = wrapEl.getBoundingClientRect();
            const menuRect = menu.getBoundingClientRect();
            const w = Math.max(menuRect.width, 10);
            const h = Math.max(menuRect.height, 10);
            gsap.set(rollEdge, { top: menuRect.top - wrapRect.top, left: menuRect.left - wrapRect.left, height: h, width: 16 });

            if (isOpening) {
                // Carpet starts rolled up flat against the left edge, then unrolls to the right.
                gsap.set(menu, { clipPath: 'inset(0 100% 0 0)' });
                gsap.set(rollEdge, { x: 0, autoAlpha: 1 });
                navRollTween = gsap.timeline({
                    // clip-path: inset(0 0% 0 0) reads as "no clipping", but it's still an
                    // active clip region sized to the menu's OWN (small) box -- harmless for
                    // the mobile/tablet accordion, whose dropdowns sit in normal flow inside
                    // that same box, but it silently clips away anything that deliberately
                    // overflows beyond it, like the absolutely-positioned desktop flyout
                    // dropdown reopened after scrolling. Clear it once fully open so the menu
                    // is governed purely by the class state again, same as finishClose() does.
                    onComplete: () => gsap.set(menu, { clearProps: 'clipPath' }),
                })
                    .to(menu, { clipPath: 'inset(0 0% 0 0)', duration: 0.75, ease: 'power3.out' }, 0)
                    .to(rollEdge, { x: w - 16, duration: 0.75, ease: 'power3.out' }, 0)
                    .to(rollEdge, { autoAlpha: 0, duration: 0.2 }, 0.55);
            } else {
                // Reverse: the carpet re-rolls from the right edge back up to the left.
                gsap.set(rollEdge, { x: w - 16, autoAlpha: 1 });
                navRollTween = gsap.timeline({ onComplete: finishClose })
                    .to(menu, { clipPath: 'inset(0 100% 0 0)', duration: 0.55, ease: 'power2.inOut' }, 0)
                    .to(rollEdge, { x: 0, duration: 0.55, ease: 'power2.inOut' }, 0)
                    .to(rollEdge, { autoAlpha: 0, duration: 0.15 }, 0.4);
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            gsap.registerPlugin(ScrollTrigger);

            // Drive the header's "scrolled" state off ScrollTrigger rather than a raw
            // window scroll listener. A plain `window.scrollY` check can desync from the
            // page's real scroll state while the homepage's pinned cinematic section is
            // active, which previously left the header stuck in its collapsed (nav-hidden)
            // look after scrolling back to the top. ScrollTrigger shares the same scroll
            // accounting as that pinned section, so it can't drift out of sync with it.
            const headerEl = document.querySelector('header');
            if (headerEl) {
                // If the hamburger-driven nav is left open while the header expands back
                // out of its scrolled/collapsed state (user scrolls to top without closing
                // it first), close it rather than leaving it open across that transition --
                // the open-panel layout is only meant to exist alongside the collapsed
                // header, and leaving it stranded is what let the two states drift apart.
                const closeNavIfOpen = () => {
                    const navMenu = document.getElementById('navMenu');
                    if (navMenu && navMenu.classList.contains('active') && typeof toggleMenu === 'function') {
                        toggleMenu();
                    }
                };
                ScrollTrigger.create({
                    start: 50,
                    onEnter: () => headerEl.classList.add('scrolled'),
                    onLeaveBack: () => { headerEl.classList.remove('scrolled'); closeNavIfOpen(); },
                    onRefresh: (self) => {
                        const stillScrolled = self.scroll() > 50;
                        headerEl.classList.toggle('scrolled', stillScrolled);
                        if (!stillScrolled) closeNavIfOpen();
                    },
                });
            }

            // Every ScrollTrigger's start/end is calculated in absolute page pixels the
            // moment it's created. Offscreen <img loading="lazy"> elements don't download
            // until they near the viewport, so any that load AFTER that initial calc (and
            // aren't held to a fixed-size container) shift the document's real height --
            // permanently desyncing every trigger positioned below them until something
            // forces a recalculation. That's what made sections further down the page
            // (methodology, testimonials, etc.) look wrong until the user actually
            // scrolled near them. Refresh once, debounced, whenever a lazy image settles.
            let lazyImgRefreshTimer = null;
            const scheduleLazyImgRefresh = () => {
                clearTimeout(lazyImgRefreshTimer);
                lazyImgRefreshTimer = setTimeout(() => ScrollTrigger.refresh(), 120);
            };
            document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                if (img.complete) return;
                img.addEventListener('load', scheduleLazyImgRefresh, { once: true });
            });

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

            // clearProps removes the inline transform once the tween finishes instead of
            // leaving it resting at translate(0px, 0px) (still a non-"none" transform
            // value) forever after. That stray transform makes the fixed header create a
            // permanent compositing layer, which mis-paints/hides descendants that extend
            // far beyond the header's own ~100px height -- like the Industries dropdown
            // flyout reopened after scrolling, which is over 300px tall.
            gsap.fromTo('header', { y: -80, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out', clearProps: 'transform' });

            // Wraps every word inside a heading in its own <span class="split-word">,
            // walking the DOM so existing markup (line breaks, the gradient <span>)
            // is preserved rather than clobbered by a naive textContent rebuild.
            function splitWords(container) {
                const words = [];
                function walk(node) {
                    if (node.nodeType === Node.TEXT_NODE) {
                        const parts = node.textContent.split(/(\s+)/);
                        const frag = document.createDocumentFragment();
                        parts.forEach(part => {
                            if (part === '') return;
                            if (/^\s+$/.test(part)) {
                                frag.appendChild(document.createTextNode(part));
                            } else {
                                const span = document.createElement('span');
                                span.className = 'split-word';
                                span.textContent = part;
                                frag.appendChild(span);
                                words.push(span);
                            }
                        });
                        node.parentNode.replaceChild(frag, node);
                    } else if (node.nodeType === Node.ELEMENT_NODE) {
                        // Gradient-clipped text (.text-gradient) paints via its own
                        // background with background-clip:text, which doesn't
                        // inherit to children — splitting its words into separate
                        // spans would strip the gradient off entirely (each child
                        // has no background of its own to clip). Animate it as one
                        // atomic unit instead of recursing into its text.
                        if (node.classList && node.classList.contains('text-gradient')) {
                            node.classList.add('split-word');
                            words.push(node);
                            return;
                        }
                        Array.from(node.childNodes).forEach(walk);
                    }
                }
                Array.from(container.childNodes).forEach(walk);
                return words;
            }

            // Hero copy plays immediately as a staggered sequence rather than
            // each line fading in independently at the same instant. The H1
            // gets a more dramatic word-by-word reveal instead of a flat fade.
            const heroHeading = document.querySelector('.hero-content h1');
            const heroHeadingWords = heroHeading ? splitWords(heroHeading) : [];
            if (heroHeadingWords.length) gsap.set(heroHeadingWords, { opacity: 0, y: 22 });

            const heroEls = gsap.utils.toArray('.hero .fade-up').filter(el => el.tagName !== 'H1');
            if (heroEls.length) {
                gsap.fromTo(heroEls, { opacity: 0, y: 30 }, {
                    opacity: 1, y: 0, duration: 0.7, stagger: 0.14, ease: 'power2.out', delay: 0.15
                });
            }
            if (heroHeadingWords.length) {
                gsap.to(heroHeadingWords, { opacity: 1, y: 0, duration: 0.6, stagger: 0.028, ease: 'power2.out', delay: 0.15 });
            }

            // Section headings (the h2 inside every .section-header) get the
            // same word-by-word treatment as they scroll into view.
            document.querySelectorAll('.section-header h2').forEach(h2 => {
                const words = splitWords(h2);
                if (!words.length) return;
                gsap.set(words, { opacity: 0, y: 18 });
                gsap.to(words, {
                    opacity: 1, y: 0, duration: 0.5, stagger: 0.025, ease: 'power2.out',
                    scrollTrigger: { trigger: h2, start: 'top 88%', toggleActions: 'play none none none' }
                });
            });

            // Every other .fade-up (section wrappers, CTA boxes, footer columns)
            // reveals as the user scrolls to it.
            gsap.utils.toArray('.fade-up').forEach(element => {
                if (heroEls.includes(element)) return;
                gsap.fromTo(element,
                    { opacity: 0, y: 40 },
                    { opacity: 1, y: 0, duration: 0.6, ease: "power2.out", clearProps: 'transform',
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
                '.cta-features', '.faq-list', '.mobile-dash-cards', '.partner-strip', '.team-grid'
            ];
            gridSelectors.forEach(selector => {
                gsap.utils.toArray(selector).forEach(grid => {
                    const items = gsap.utils.toArray(grid.children);
                    items.forEach((item, i) => {
                        gsap.fromTo(item, { opacity: 0, y: 34 }, {
                            opacity: 1, y: 0, duration: 0.55, delay: (i % 3) * 0.08, ease: 'power2.out', clearProps: 'transform',
                            scrollTrigger: { trigger: item, start: 'top 90%', toggleActions: 'play none none none' }
                        });
                    });
                });
            });

            // === "OUR EXPERTISE": scroll-driven pinned storytelling (index.php +
            // services.php) === See the big comment above .expertise-scroll-wrap in
            // css/style.css for the full design. The CSS default is a plain,
            // always-expanded stacked list of panels -- that's what mobile, reduced
            // motion, and (if this never runs) no-JS visitors get. Only on wide
            // screens with motion allowed do we escalate to the interactive version:
            // one item's giant centered title holds, fades/slides out while its row
            // grows into an accumulating numbered list and its image panel expands,
            // then the panel collapses (row stays) as the next item's title fades in.
            document.querySelectorAll('.expertise-scroll-wrap').forEach(wrap => {
                const rows = gsap.utils.toArray(wrap.querySelectorAll('.expertise-row'));
                const heroes = gsap.utils.toArray(wrap.querySelectorAll('.expertise-hero'));
                const panels = gsap.utils.toArray(wrap.querySelectorAll('.expertise-panel'));
                const n = rows.length;
                if (!n) return;

                mm.add('(min-width: 900px)', () => {
                    const section = wrap.closest('.expertise-scroll-section');
                    section.classList.add('expertise-js-ready');
                    const pinEl = wrap.querySelector('.expertise-pin');

                    // A row's height:auto isn't tweenable, so measure its inner
                    // content's natural pixel height up front -- the row itself is
                    // already visually collapsed to 0 by CSS regardless, this just
                    // records what "open" should animate to.
                    rows.forEach(row => {
                        row._openHeight = row.querySelector('.expertise-row-inner').offsetHeight;
                    });

                    gsap.set(heroes, { autoAlpha: 0 });
                    gsap.set(heroes[0], { autoAlpha: 1 });
                    gsap.set(panels, { autoAlpha: 0, scale: 0.97 });
                    gsap.set(rows, { height: 0, opacity: 0 });

                    // "top 75px" (not "top top") so the pinned stage settles just below
                    // the fixed header's scrolled height instead of directly underneath
                    // it -- by the time a visitor has scrolled this far the header is
                    // already in its .scrolled (75px) state for effectively the entire
                    // pinned duration.
                    const tl = gsap.timeline({
                        scrollTrigger: {
                            trigger: wrap,
                            start: 'top 75px',
                            end: () => '+=' + Math.round(n * window.innerHeight * 0.85),
                            scrub: 0.6,
                            pin: pinEl,
                            anticipatePin: 1,
                            invalidateOnRefresh: true,
                        }
                    });

                    rows.forEach((row, i) => {
                        if (i === 0) {
                            tl.to({}, { duration: 0.4 }); // reading pause on the first hero, already visible at rest
                        } else {
                            tl.to(heroes[i], { autoAlpha: 1, duration: 0.35 });
                            tl.to({}, { duration: 0.25 });
                        }
                        // Hero fades/slides toward the list while its row grows open --
                        // two separate elements, timed to overlap, rather than a literal
                        // shared-element morph (far more fragile to keep smooth/bug-free
                        // across every viewport), but reads as one continuous movement.
                        tl.to(heroes[i], { autoAlpha: 0, x: -50, scale: 0.4, duration: 0.35, ease: 'power2.in' });
                        tl.to(row, { height: row._openHeight, opacity: 1, duration: 0.35, ease: 'power2.out' }, '<');
                        tl.to(panels[i], { autoAlpha: 1, scale: 1, duration: 0.4, ease: 'power2.out' }, '<0.1');
                        tl.to({}, { duration: 0.6 }); // reading pause on the expanded panel
                        // The last item's panel stays expanded at rest instead of
                        // collapsing away to an empty stage right as the pin releases.
                        if (i < n - 1) {
                            tl.to(panels[i], { autoAlpha: 0, scale: 0.97, duration: 0.3, ease: 'power2.in' });
                        }
                    });

                    return () => section.classList.remove('expertise-js-ready');
                });

                // Below 900px the pin never engages (see the CSS) -- panels are
                // always statically expanded, just fading up into view individually
                // as the user reaches them, same as every other grid on the site.
                mm.add('(max-width: 899px)', () => {
                    panels.forEach(panel => {
                        gsap.fromTo(panel, { opacity: 0, y: 34 }, {
                            opacity: 1, y: 0, duration: 0.55, ease: 'power2.out', clearProps: 'transform',
                            scrollTrigger: { trigger: panel, start: 'top 90%', toggleActions: 'play none none none' }
                        });
                    });
                    return () => {};
                });
            });

            // Two-column image/text (or info/form) sections slide in from opposite sides --
            // only at the desktop width where these grids are actually two columns (matches
            // the CSS breakpoint that collapses .agency-grid/.methodology-grid/.contact-grid
            // to a single column at 1024px and below). Without this guard, the initial
            // x:50/x:-50 offset below was being applied at every viewport width, pushing
            // content 50px past the single-column mobile layout's edge and causing
            // horizontal page overflow on every page that uses these grids.
            mm.add("(min-width: 1025px)", () => {
                gsap.utils.toArray('.agency-grid, .methodology-grid, .contact-grid').forEach(grid => {
                    const media = grid.querySelector('.agency-image-wrapper, .methodology-image, .contact-info-card');
                    const copy = grid.querySelector('.agency-text, .methodology-steps, .contact-form-card');
                    const trigger = { trigger: grid, start: 'top 82%', toggleActions: 'play none none none' };
                    if (media) gsap.fromTo(media, { opacity: 0, x: -50 }, { opacity: 1, x: 0, duration: 0.8, ease: 'power2.out', scrollTrigger: trigger });
                    if (copy) gsap.fromTo(copy, { opacity: 0, x: 50 }, { opacity: 1, x: 0, duration: 0.8, ease: 'power2.out', scrollTrigger: trigger });
                });
                return () => {};
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

