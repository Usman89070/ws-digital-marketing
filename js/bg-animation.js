// Fixed, full-page Three.js particle-network background animation.
// Split into its own deferred file (loaded after js/main.js and three.min.js)
// so this much heavier library never delays the header/nav becoming interactive.

        (function () {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (typeof THREE === 'undefined' || prefersReducedMotion) return;

            const canvas = document.createElement('canvas');
            canvas.id = 'page-bg-canvas';
            document.body.insertBefore(canvas, document.body.firstChild);

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
                size: isMobile ? 1.4 : 1.8,
                vertexColors: true,
                transparent: true,
                opacity: 0.95,
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
            const lineMaterial = new THREE.LineBasicMaterial({ vertexColors: true, transparent: true, opacity: 0.32 });
            group.add(new THREE.LineSegments(lineGeometry, lineMaterial));

            // Pointer reactivity: cursor position drives both a tilt (rotation) and a
            // slight camera-relative drift (position), so the network visibly leans
            // toward and reacts to wherever the pointer is.
            let targetRotX = 0, targetRotY = 0, targetPosX = 0;
            window.addEventListener('mousemove', (e) => {
                const nx = (e.clientX / window.innerWidth) - 0.5;
                const ny = (e.clientY / window.innerHeight) - 0.5;
                targetRotY = nx * 0.6;
                targetRotX = ny * 0.35;
                targetPosX = nx * -8;
            }, { passive: true });

            function resize() {
                const w = window.innerWidth;
                const h = window.innerHeight;
                if (!w || !h) return;
                renderer.setSize(w, h, false);
                camera.aspect = w / h;
                camera.updateProjectionMatrix();
            }
            resize();
            window.addEventListener('resize', resize);

            let rafId = null;
            let readyFlagged = false;
            function animate() {
                rafId = requestAnimationFrame(animate);
                if (document.hidden) return;

                // Scroll reactivity: read scroll progress fresh every frame (instead of a
                // separate scroll listener) so it can never drift out of sync with the
                // page's real position, including during pinned ScrollTrigger sections.
                const scrollable = document.documentElement.scrollHeight - window.innerHeight;
                const scrollProgress = scrollable > 0 ? Math.min(Math.max(window.scrollY / scrollable, 0), 1) : 0;

                group.rotation.y += 0.0012;
                group.rotation.x += (targetRotX - group.rotation.x) * 0.03;
                group.rotation.y += (targetRotY - group.rotation.y) * 0.02;
                group.position.x += (targetPosX - group.position.x) * 0.04;

                // Scroll parallax: a slow twist plus vertical drift tied to how far down
                // the page the user has scrolled, layered on top of the pointer tilt above.
                const scrollTargetZ = (scrollProgress - 0.5) * 0.7;
                const scrollTargetY = -scrollProgress * 18;
                group.rotation.z += (scrollTargetZ - group.rotation.z) * 0.04;
                group.position.y += (scrollTargetY - group.position.y) * 0.04;

                renderer.render(scene, camera);

                if (!readyFlagged) {
                    canvas.classList.add('is-ready');
                    readyFlagged = true;
                }
            }
            animate();
        })();
