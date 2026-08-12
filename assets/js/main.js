(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---------------------------------------------------------------------
       Sticky header + scroll progress
       ------------------------------------------------------------------- */
    var header = document.getElementById('siteHeader');
    var progress = document.getElementById('scrollProgress');

    function onScroll() {
        var y = window.scrollY || document.documentElement.scrollTop;

        if (header) header.classList.toggle('scrolled', y > 30);

        if (progress) {
            var docHeight = document.documentElement.scrollHeight - window.innerHeight;
            var pct = docHeight > 0 ? (y / docHeight) * 100 : 0;
            progress.style.width = pct + '%';
        }
    }
    document.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* ---------------------------------------------------------------------
       Mobile nav toggle
       ------------------------------------------------------------------- */
    var navToggle = document.getElementById('navToggle');
    var mainNav = document.getElementById('mainNav');

    if (navToggle && mainNav) {
        navToggle.addEventListener('click', function () {
            var isOpen = mainNav.classList.toggle('open');
            navToggle.classList.toggle('open', isOpen);
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        mainNav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                mainNav.classList.remove('open');
                navToggle.classList.remove('open');
                navToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /* ---------------------------------------------------------------------
       Back to top
       ------------------------------------------------------------------- */
    var backToTop = document.getElementById('backToTop');
    if (backToTop) {
        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
        });
    }

    /* ---------------------------------------------------------------------
       Scroll reveal (fade-up)
       ------------------------------------------------------------------- */
    var revealEls = document.querySelectorAll('.fade-up');

    if ('IntersectionObserver' in window && !reduceMotion) {
        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

        revealEls.forEach(function (el) { revealObserver.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('in-view'); });
    }

    /* ---------------------------------------------------------------------
       3D tilt — hero device stage (mouse parallax, resting angle on touch)
       ------------------------------------------------------------------- */
    var stage = document.getElementById('devicesStage');
    var laptop = document.getElementById('laptopTilt');
    var mobile = document.getElementById('mobileTilt');

    var laptopBase = { rx: 14, ry: -16, rz: 1 };
    var mobileBase = { rx: 6, ry: 14, rz: -3 };

    if (stage && laptop && !reduceMotion && window.matchMedia('(hover: hover)').matches) {
        stage.addEventListener('mousemove', function (e) {
            var rect = stage.getBoundingClientRect();
            var px = (e.clientX - rect.left) / rect.width - 0.5;
            var py = (e.clientY - rect.top) / rect.height - 0.5;

            laptop.style.transform =
                'rotateX(' + (laptopBase.rx - py * 12) + 'deg) ' +
                'rotateY(' + (laptopBase.ry + px * 16) + 'deg) ' +
                'rotateZ(' + laptopBase.rz + 'deg)';

            if (mobile) {
                mobile.style.transform =
                    'rotateX(' + (mobileBase.rx - py * 10) + 'deg) ' +
                    'rotateY(' + (mobileBase.ry + px * 12) + 'deg) ' +
                    'rotateZ(' + mobileBase.rz + 'deg)';
            }
        });

        stage.addEventListener('mouseleave', function () {
            laptop.style.transform = 'rotateX(' + laptopBase.rx + 'deg) rotateY(' + laptopBase.ry + 'deg) rotateZ(' + laptopBase.rz + 'deg)';
            if (mobile) {
                mobile.style.transform = 'rotateX(' + mobileBase.rx + 'deg) rotateY(' + mobileBase.ry + 'deg) rotateZ(' + mobileBase.rz + 'deg)';
            }
        });
    }

    /* ---------------------------------------------------------------------
       3D tilt-on-hover for cards
       ------------------------------------------------------------------- */
    function applyCardTilt(selector, maxDeg) {
        if (reduceMotion || !window.matchMedia('(hover: hover)').matches) return;

        document.querySelectorAll(selector).forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                var rect = card.getBoundingClientRect();
                var px = (e.clientX - rect.left) / rect.width - 0.5;
                var py = (e.clientY - rect.top) / rect.height - 0.5;
                card.style.transform =
                    'perspective(900px) rotateX(' + (-py * maxDeg) + 'deg) rotateY(' + (px * maxDeg) + 'deg) translateY(-6px)';
            });

            card.addEventListener('mouseleave', function () {
                card.style.transform = 'perspective(900px) rotateX(0deg) rotateY(0deg) translateY(0)';
            });
        });
    }

    applyCardTilt('.service-card', 8);
    applyCardTilt('.testi-card', 6);
    applyCardTilt('.industry-card', 10);

    /* ---------------------------------------------------------------------
       Count-up stats
       ------------------------------------------------------------------- */
    function animateValue(target, decimals, suffix, node, duration) {
        var start = 0;
        var startTime = null;

        function step(ts) {
            if (!startTime) startTime = ts;
            var progressRatio = Math.min((ts - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progressRatio, 3);
            var current = start + (target - start) * eased;
            node.textContent = current.toFixed(decimals) + suffix;

            if (progressRatio < 1) {
                requestAnimationFrame(step);
            } else {
                node.textContent = target.toFixed(decimals) + suffix;
            }
        }
        requestAnimationFrame(step);
    }

    function setupCounter(el) {
        var raw = (el.childNodes[0] && el.childNodes[0].nodeType === Node.TEXT_NODE)
            ? el.childNodes[0].textContent
            : el.textContent;

        var match = raw.trim().match(/^([\d.]+)(.*)$/);
        if (!match) return null;

        var target = parseFloat(match[1]);
        var suffix = match[2] || '';
        var decimals = match[1].indexOf('.') > -1 ? match[1].split('.')[1].length : 0;

        var countNode = document.createElement('span');
        countNode.className = 'count-value';
        countNode.textContent = '0' + suffix;

        if (el.childNodes[0] && el.childNodes[0].nodeType === Node.TEXT_NODE) {
            el.replaceChild(countNode, el.childNodes[0]);
        } else {
            el.textContent = '';
            el.appendChild(countNode);
        }

        return { target: target, decimals: decimals, suffix: suffix, node: countNode };
    }

    var counters = [];
    document.querySelectorAll('[data-count]').forEach(function (el) {
        var cfg = setupCounter(el);
        if (cfg) counters.push(cfg);
    });

    if (counters.length) {
        if ('IntersectionObserver' in window) {
            var counterObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var cfg = counters.find(function (c) { return c.node.closest('[data-count]') === entry.target; });
                        if (cfg) {
                            animateValue(cfg.target, cfg.decimals, cfg.suffix, cfg.node, 1600);
                        }
                        counterObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.4 });

            document.querySelectorAll('[data-count]').forEach(function (el) {
                counterObserver.observe(el);
            });
        } else {
            counters.forEach(function (c) {
                c.node.textContent = c.target.toFixed(c.decimals) + c.suffix;
            });
        }
    }

})();
