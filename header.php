<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>W&S Digital Marketing | Premium Agency</title>

    <!-- Include GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <!-- FontAwesome for Professional Realistic Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* === CORE CSS & VARIABLES === */
        :root {
            --navy: #0B0F25;
            --cyan-neon: #00F2FE;
            --magenta-neon: #FF007F;
            --text-muted: #5A6482;
            --bg-secondary: #F8FAFC;
            --border-light: #E2E8F0;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 10px 30px -5px rgba(11, 15, 37, 0.08);
            --shadow-hover: 0 20px 40px -5px rgba(11, 15, 37, 0.12);
            --shadow-3d: 0 45px 90px -20px rgba(11, 15, 37, 0.45);
            --transition-smooth: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        body { overflow-x: hidden; color: var(--navy); background-color: #ffffff; }

        .container { max-width: 1300px; margin: 0 auto; padding: 0 5%; width: 100%; }

        .eyebrow { color: var(--magenta-neon); font-weight: 700; letter-spacing: 2px; font-size: 0.85rem; text-transform: uppercase; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px; }
        .eyebrow::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--cyan-neon); box-shadow: 0 0 10px 2px rgba(0, 242, 254, 0.6); animation: pulse-dot 2s ease-in-out infinite; flex-shrink: 0; }
        @keyframes pulse-dot { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.5); opacity: 0.55; } }
        .section-header { text-align: center; margin-bottom: clamp(30px, 6vw, 60px); }
        .section-header.left { text-align: left; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.001ms !important; animation-iteration-count: 1 !important; transition-duration: 0.001ms !important; scroll-behavior: auto !important; }
        }

        /* === UPGRADED PREMIUM SOLID DARK HEADER (NO BLUR) === */
        header {
            height: 100px; display: flex; align-items: center; position: fixed;
            width: 100%; top: 0; z-index: 1000; background: #0B0F25;
            border-bottom: 1px solid rgba(0, 242, 254, 0.15);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        header.scrolled {
            height: 75px;
            background: #050814;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border-bottom: 1px solid rgba(0, 242, 254, 0.3);
        }
        .nav-wrapper { display: flex; justify-content: space-between; align-items: center; width: 100%; height: 100%; }

        .logo { display: flex; align-items: center; height: 100%; text-decoration: none; }
        .logo-img { height: clamp(38px, 5vw, 50px); width: auto; display: block; object-fit: contain; transition: transform 0.3s ease; }
        .logo:hover .logo-img { transform: scale(1.05) rotate(-2deg); }

        .nav-menu { display: flex; gap: 28px; list-style: none; align-items: center; margin: 0; padding: 0; }
        .nav-menu li a {
            text-decoration: none; color: rgba(255,255,255,0.9); font-weight: 500;
            font-size: 0.95rem; position: relative; padding: 5px 0; transition: color 0.3s ease;
        }
        .nav-menu li a::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px;
            background: var(--cyan-neon); transition: width 0.3s ease; border-radius: 2px;
            box-shadow: 0 0 8px rgba(0, 242, 254, 0.5);
        }
        .nav-menu li a:hover { color: #fff; }
        .nav-menu li a:hover::after { width: 100%; }

        /* === DROPDOWN MENU STYLING (SOLID BACKGROUND) === */
        .dropdown { position: relative; }
        .dropdown-menu {
            position: absolute; top: 100%; left: 0; background: #0B0F25;
            min-width: 250px; border-radius: 12px; border: 1px solid rgba(0, 242, 254, 0.2);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6); padding: 10px 0; list-style: none;
            opacity: 0; visibility: hidden; transform: translateY(10px) rotateX(-8deg); transform-origin: top center;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 1002;
        }
        .dropdown:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0) rotateX(0deg); }
        .dropdown-menu li { width: 100%; text-align: left; }
        .dropdown-menu li a {
            display: block; padding: 10px 20px; font-size: 0.9rem; color: rgba(255,255,255,0.8);
            transition: all 0.2s ease; border-bottom: none !important;
        }
        .dropdown-menu li a::after { display: none !important; }
        .dropdown-menu li a:hover { background: rgba(0, 242, 254, 0.1); color: var(--cyan-neon); transform: translateX(4px); }

        .header-cta {
            background: transparent; border: 2px solid var(--cyan-neon); color: var(--cyan-neon);
            padding: 10px 24px; border-radius: 50px; font-weight: 700; font-size: 0.85rem;
            text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s ease;
            text-decoration: none; box-shadow: 0 0 10px rgba(0, 242, 254, 0.1);
        }
        .header-cta:hover {
            background: var(--cyan-neon); color: var(--navy); box-shadow: 0 0 20px rgba(0, 242, 254, 0.4); transform: translateY(-2px);
        }

        .mobile-btn {
            display: none; font-size: 2rem; background: none; border: none;
            cursor: pointer; color: #fff; z-index: 1001; transition: transform 0.3s ease;
            margin-left: auto;
        }
        .mobile-btn:hover { color: var(--cyan-neon); transform: scale(1.1); }

        /* === BUTTONS (3D press + shimmer) === */
        .btn-primary {
            background: linear-gradient(135deg, var(--cyan-neon), var(--magenta-neon));
            background-size: 200% 200%;
            color: #fff; padding: 15px 32px; border-radius: 8px; text-decoration: none;
            font-weight: 600; transition: transform 0.4s var(--ease-spring), box-shadow 0.4s var(--transition-smooth), background-position 0.4s ease;
            border: none; cursor: pointer; display: inline-block;
            box-shadow: 0 4px 15px rgba(0, 242, 254, 0.25); text-align: center; font-size: 1rem;
            position: relative; overflow: hidden; transform-style: preserve-3d;
        }
        .btn-primary span { position: relative; z-index: 2; }
        .btn-primary::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.45) 50%, transparent 70%);
            transform: translateX(-120%); transition: transform 0.7s ease; z-index: 1;
        }
        .btn-primary:hover { transform: perspective(600px) translateY(-3px) rotateX(8deg) scale(1.02); box-shadow: 0 15px 35px rgba(255, 0, 127, 0.35); background-position: 100% 50%; }
        .btn-primary:hover::before { transform: translateX(120%); }
        .btn-primary:active { transform: perspective(600px) translateY(-1px) scale(0.98); }

        .btn-secondary {
            border: 2px solid var(--border-light); color: var(--navy);
            padding: 15px 32px; border-radius: 8px; text-decoration: none;
            font-weight: 600; transition: transform 0.4s var(--ease-spring), background 0.4s, color 0.4s, border-color 0.4s;
            display: inline-block; background: transparent; text-align: center; font-size: 1rem;
        }
        .btn-secondary:hover { border-color: var(--navy); background: var(--navy); color: #fff; transform: perspective(600px) translateY(-3px) rotateX(8deg); }

        /* === SECTION 1: HERO === */
        .hero { background: #ffffff; color: var(--navy); position: relative; z-index: 10; margin-top: 85px; padding: clamp(60px, 12vw, 120px) 0 clamp(40px, 8vw, 80px); overflow: hidden; }
        .hero-orb { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.35; pointer-events: none; animation: orb-float 16s ease-in-out infinite; z-index: 0; }
        .hero-orb-1 { width: 420px; height: 420px; top: -140px; left: -140px; background: radial-gradient(circle, var(--cyan-neon), transparent 70%); }
        .hero-orb-2 { width: 380px; height: 380px; bottom: -160px; right: -120px; background: radial-gradient(circle, var(--magenta-neon), transparent 70%); animation-delay: -8s; }
        @keyframes orb-float { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(40px, -30px) scale(1.1); } }
        .hero-grid-overlay {
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
            background-image: linear-gradient(rgba(11,15,37,0.035) 1px, transparent 1px), linear-gradient(90deg, rgba(11,15,37,0.035) 1px, transparent 1px);
            background-size: 46px 46px;
            mask-image: radial-gradient(ellipse 70% 55% at 50% 20%, #000 40%, transparent 100%);
            -webkit-mask-image: radial-gradient(ellipse 70% 55% at 50% 20%, #000 40%, transparent 100%);
        }
        .hero-content { max-width: 950px; margin: 0 auto; text-align: center; position: relative; z-index: 2; }
        .hero-content h1 { font-size: clamp(2rem, 5.5vw, 4.5rem); line-height: 1.1; margin: 15px 0 25px; color: var(--navy); font-weight: 800; letter-spacing: -1px; }
        .hero-subtitle { font-size: clamp(1rem, 2vw, 1.25rem); color: var(--text-muted); max-width: 700px; margin: 0 auto; line-height: 1.6; }
        .text-gradient {
            background: linear-gradient(135deg, var(--navy) 10%, var(--magenta-neon) 55%, var(--cyan-neon) 100%);
            background-size: 250% auto;
            -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
            animation: gradient-flow 7s ease-in-out infinite;
            display: inline-block;
        }
        @keyframes gradient-flow { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        .hero-buttons { display: flex; gap: 20px; margin-top: 40px; justify-content: center; flex-wrap: wrap; }

        /* === MASTER CINEMATIC STAGE (3D perspective stage) === */
        .cinematic-wrapper { background-color: #ffffff; width: 100%; height: calc(100vh - 85px); min-height: 700px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; perspective: 2200px; }
        .devices-stage { position: relative; width: 1000px; height: 650px; max-width: 100%; flex-shrink: 0; transform-origin: center center; display: flex; align-items: center; justify-content: center; transform-style: preserve-3d; }

        .stage-header { position: absolute; top: 35px; left: 0; width: 100%; text-align: center; opacity: 0; z-index: 15; padding: 0 15px; }
        .stage-header h2 { font-size: clamp(1.6rem, 4vw, 2.5rem); font-weight: 800; margin-top: 8px; color: var(--navy); line-height: 1.1; }

        .scatter-item { position: absolute; top: 50%; left: 50%; background: #fff; padding: 12px 20px; border-radius: 12px; box-shadow: var(--shadow-md); border: 1px solid var(--border-light); font-weight: 700; z-index: 40; display: flex; flex-direction: column; gap: 4px; min-width: 150px; text-align: left; transform-style: preserve-3d; }
        .scatter-item span { font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; }
        .val { display: flex; align-items: center; gap: 6px; }
        .fs-1 .val { color: var(--cyan-neon); font-size: 1.1rem; }
        .fs-2 .val { color: #00C48C; font-size: 1.1rem;}
        .fs-3 .val { color: var(--magenta-neon); font-size: 1.1rem;}
        .fs-4 .val { color: #FF9800; font-size: 1.1rem;}

        .laptop-container { position: absolute; bottom: 10px; left: 50%; width: 750px; max-width: 95%; display: flex; flex-direction: column; align-items: center; opacity: 0; z-index: 10; transform-style: preserve-3d; }
        .mac-screen-bezel { width: 100%; height: 350px; background: #1e222a; border-radius: 14px 14px 0 0; padding: 8px 8px 12px 8px; box-shadow: var(--shadow-3d); position: relative; }
        .mac-camera { position: absolute; top: 4px; left: 50%; transform: translateX(-50%); width: 5px; height: 5px; background: #333; border-radius: 50%; box-shadow: 0 0 4px 1px rgba(0,242,254,0.5); }

        .dashboard-ui { width: 100%; height: 100%; background: var(--bg-secondary); border-radius: 4px; overflow: hidden; display: flex; }
        .dash-sidebar { width: 45px; background: #fff; border-right: 1px solid var(--border-light); display: flex; flex-direction: column; align-items: center; padding-top: 15px; gap: 12px; }
        .dash-sidebar .icon { width: 18px; height: 18px; background: #eef2ff; border-radius: 5px; }
        .dash-main { flex: 1; padding: 15px; display: flex; flex-direction: column; }
        .dash-topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .dash-title { font-weight: 700; font-size: 0.9rem; color: var(--navy); }
        .dash-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 10px; }
        .dash-card { background: #fff; padding: 6px 8px; border-radius: 6px; border: 1px solid var(--border-light); }
        .dash-card-title { font-size: 0.55rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 2px; }
        .dash-card-value { font-size: 0.85rem; font-weight: 800; color: var(--navy); }

        .dash-chart-area { flex: 1; background: #fff; border-radius: 6px; border: 1px solid var(--border-light); padding: 10px; position: relative; overflow: hidden; display: flex; align-items: flex-end; gap: 12px; }
        .dash-chart-bars { display: flex; align-items: flex-end; gap: 4px; width: 45%; height: 100%; padding-bottom: 2px; }
        .dash-chart-bars span { flex: 1; height: var(--h); background: linear-gradient(180deg, var(--cyan-neon), var(--magenta-neon)); border-radius: 3px 3px 0 0; opacity: 0.85; transform-origin: bottom; transform: scaleY(0); transition: transform 0.7s var(--ease-spring); }
        .dash-chart-bars span:nth-child(1) { transition-delay: 0.05s; }
        .dash-chart-bars span:nth-child(2) { transition-delay: 0.11s; }
        .dash-chart-bars span:nth-child(3) { transition-delay: 0.17s; }
        .dash-chart-bars span:nth-child(4) { transition-delay: 0.23s; }
        .dash-chart-bars span:nth-child(5) { transition-delay: 0.29s; }
        .dash-chart-bars span:nth-child(6) { transition-delay: 0.35s; }
        .dash-chart-bars span:nth-child(7) { transition-delay: 0.41s; }
        .dash-chart-bars span:nth-child(8) { transition-delay: 0.47s; }
        .stage-in-view .dash-chart-bars span { transform: scaleY(1); }
        .dash-chart-line { position: absolute; inset: 0; width: 100%; height: 100%; pointer-events: none; }
        .dash-chart-line polyline { fill: none; stroke: var(--cyan-neon); stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; stroke-dasharray: 400; stroke-dashoffset: 400; }
        .stage-in-view .dash-chart-line polyline { animation: draw-line 1.8s ease-out 0.3s forwards; }
        @keyframes draw-line { to { stroke-dashoffset: 0; } }
        .dash-chart-label { position: absolute; top: 8px; left: 10px; font-weight: 700; font-size: 0.62rem; color: var(--navy); z-index: 2; }

        .mac-base { width: 108%; height: 18px; background: linear-gradient(to bottom, #d1d5db, #9ca3af); border-radius: 0 0 10px 10px; position: relative; box-shadow: 0 10px 20px rgba(0,0,0,0.2); display: flex; justify-content: center; }
        .mac-notch { width: 80px; height: 3px; background: #7c839a; border-radius: 0 0 3px 3px; }

        .mobile-container { position: absolute; top: 48%; left: 50%; width: 210px; height: 430px; background: #fff; border: 7px solid var(--navy); border-radius: 28px; box-shadow: var(--shadow-3d); z-index: 50; overflow: hidden; display: flex; flex-direction: column; will-change: left, top, transform; transform-style: preserve-3d; }
        .iphone-island { position: absolute; top: 6px; left: 50%; transform: translateX(-50%); width: 55px; height: 14px; background: var(--navy); border-radius: 8px; z-index: 60;}
        .phone-inner { width: 100%; height: 100%; position: relative; background: #fff; }

        .serp-screen-wrapper { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; pointer-events: auto; z-index: 30; }
        .serp-screen { padding: 35px 10px 10px 10px; width: 100%; display: flex; flex-direction: column; gap: 8px; position: absolute; top: 0; left: 0; will-change: transform; pointer-events: auto; }

        .serp-item { border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .serp-link { text-decoration: none; display: block; cursor: pointer !important; position: relative; z-index: 100; pointer-events: auto; }
        .serp-link:hover .serp-title { text-decoration: underline; color: #0056b3; }
        .serp-url { font-size: 0.5rem; color: #202124; display: flex; align-items: center; gap: 3px; margin-bottom: 2px; }
        .serp-url img { width: 8px; height: 8px; border-radius: 50%; }
        .serp-title { font-size: 0.7rem; color: #1a0dab; font-weight: 500; line-height: 1.2; margin-bottom: 2px; }
        .serp-desc { font-size: 0.58rem; color: #4d5156; line-height: 1.3; }

        .logo-screen { position: absolute; inset: 0; background: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; z-index: 25; pointer-events: none; }
        .logo-screen img { width: 90px; height: auto; object-fit: contain; filter: drop-shadow(0 10px 15px rgba(0,242,254,0.3)); }
        .logo-screen-sub { font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1.5px; margin-top: 6px; font-weight: 600; }

        /* === MOBILE PERFORMANCE OVERVIEW === */
        .mobile-perf-overview { display: none; padding: 20px 5% 60px 5%; background: #ffffff; }
        .dash-ui-mobile { background: #fff; border: 1px solid var(--border-light); border-radius: 16px; padding: 20px; box-shadow: var(--shadow-md); }
        .mobile-dash-cards { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 15px;}
        .m-dash-card { background: var(--bg-secondary); padding: 15px 10px; border-radius: 8px; border: 1px solid var(--border-light); text-align: center; }
        .m-dash-card-title { font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 4px; }
        .m-dash-card-value { font-size: 1.2rem; font-weight: 800; color: var(--navy); }

        /* === PREMIUM ABOUT / AGENCY SECTION === */
        .agency-section { padding: clamp(60px, 8vw, 100px) 0; background: #ffffff; }
        .agency-grid { display: grid; grid-template-columns: 1fr 1fr; gap: clamp(30px, 5vw, 60px); align-items: center; }
        .agency-text h2 { font-size: clamp(1.8rem, 4vw, 2.8rem); color: var(--navy); font-weight: 800; margin-bottom: 20px; line-height: 1.1; }
        .agency-text p { color: var(--text-muted); font-size: clamp(0.95rem, 1.5vw, 1.05rem); line-height: 1.7; margin-bottom: 25px; }
        .agency-list { list-style: none; margin-bottom: 30px; }
        .agency-list li { display: flex; align-items: center; gap: 12px; margin-bottom: 15px; font-size: clamp(0.9rem, 1.5vw, 1rem); color: var(--navy); font-weight: 600; }
        .agency-list li i { color: var(--cyan-neon); font-size: 1.2rem; }
        .agency-image-wrapper { position: relative; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-hover); transform: perspective(1200px) rotateY(-6deg) rotateX(2deg); transition: transform 0.5s var(--transition-smooth); }
        .agency-image-wrapper:hover { transform: perspective(1200px) rotateY(0deg) rotateX(0deg); }
        .agency-image-wrapper img { width: 100%; height: auto; display: block; object-fit: cover; transition: transform 0.5s ease; }
        .agency-image-wrapper:hover img { transform: scale(1.03); }

        /* === TRUSTED STRIP === */
        .trusted-strip-wrapper { background: var(--bg-secondary); padding: 40px 0; border-top: 1px solid var(--border-light); border-bottom: 1px solid var(--border-light); }
        .partner-strip { display: flex; justify-content: center; align-items: center; gap: clamp(25px, 5vw, 80px); flex-wrap: wrap; }
        .partner-strip div { font-size: clamp(1.1rem, 2.5vw, 1.5rem); font-weight: 800; color: #94A3B8; transition: var(--transition-smooth); cursor: default; display: flex; align-items: center; gap: 8px;}
        .partner-strip div i { font-size: 1.2em; }
        .partner-strip div:hover { color: var(--navy); transform: translateY(-2px); }
        .partner-strip span { font-size: 0.8rem; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }

        /* === PREMIUM DARK STATS SECTION WITH REAL IMAGE BACKGROUND === */
        .stats-section { background: linear-gradient(rgba(11, 15, 37, 0.9), rgba(11, 15, 37, 0.95)), url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1920&q=80') center/cover fixed; padding: clamp(60px, 8vw, 120px) 0; position: relative; color: #fff; }
        .stats-4-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 220px), 1fr)); gap: 30px; position: relative; z-index: 2;}
        .stat-box { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); padding: clamp(25px, 4vw, 40px) 20px; border-radius: 20px; text-align: center; backdrop-filter: blur(15px); transition: var(--transition-smooth); }
        .stat-box:hover { transform: translateY(-10px); background: rgba(255, 255, 255, 0.1); border-color: rgba(0, 242, 254, 0.4); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3); }
        .stat-box h3 { font-size: clamp(2.2rem, 4vw, 3.2rem); font-weight: 800; margin-bottom: 10px; background: linear-gradient(135deg, var(--cyan-neon), var(--magenta-neon)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .stat-box p { font-size: clamp(0.85rem, 1.5vw, 1rem); color: rgba(255,255,255,0.8); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }

        /* === UPGRADED SERVICES SECTION === */
        .services-section { padding: clamp(60px, 8vw, 100px) 0; background: var(--bg-secondary); }
        .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr)); gap: 35px; margin-top: clamp(30px, 5vw, 50px);}
        .service-card { background: #fff; border: 1px solid var(--border-light); border-radius: 20px; transition: box-shadow 0.4s var(--transition-smooth), border-color 0.4s var(--transition-smooth), transform 0.15s ease-out; box-shadow: var(--shadow-sm); overflow: hidden; display: flex; flex-direction: column; transform-style: preserve-3d; will-change: transform; }
        .service-card:hover { box-shadow: var(--shadow-hover); border-color: var(--cyan-neon); }
        .service-image { width: 100%; height: 200px; position: relative; overflow: hidden; }
        .service-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
        .service-card:hover .service-image img { transform: scale(1.08); }
        .service-image::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(11, 15, 37, 0.4) 0%, transparent 100%); pointer-events: none; }
        .service-icon-badge { position: absolute; bottom: 15px; left: 25px; width: 45px; height: 45px; background: var(--cyan-neon); color: var(--navy); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 4px 15px rgba(0, 242, 254, 0.3); z-index: 2; transform: translateZ(25px); transition: transform 0.4s var(--ease-spring); }
        .service-card:hover .service-icon-badge { transform: translateZ(25px) scale(1.15) rotate(-8deg); }
        .service-content { padding: 30px 25px; flex: 1; display: flex; flex-direction: column; }
        .service-content h3 { font-size: 1.3rem; margin-bottom: 12px; color: var(--navy); font-weight: 700; }
        .service-content p { color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px; flex: 1; }
        .service-link { font-weight: 700; color: var(--navy); text-decoration: none; font-size: 0.9rem; display: flex; align-items: center; gap: 5px; transition: var(--transition-smooth); }
        .service-card:hover .service-link { color: var(--cyan-neon); }
        .service-link i { transition: transform 0.3s ease; }
        .service-card:hover .service-link i { transform: translateX(5px); }

        /* === PREMIUM METHODOLOGY === */
        .methodology-section { padding: clamp(60px, 8vw, 100px) 0; background: #fff; }
        .methodology-grid { display: grid; grid-template-columns: 1fr 1fr; gap: clamp(30px, 5vw, 60px); align-items: center; margin-top: clamp(30px, 5vw, 50px); }
        .methodology-image { border-radius: 20px; overflow: hidden; height: 100%; min-height: 400px; position: relative; box-shadow: var(--shadow-md); transform: perspective(1200px) rotateY(-5deg) rotateX(2deg); transition: transform 0.5s var(--transition-smooth); }
        .methodology-image:hover { transform: perspective(1200px) rotateY(0deg) rotateX(0deg); }
        .methodology-image img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; transition: transform 0.6s ease; }
        .methodology-image:hover img { transform: scale(1.05); }
        .methodology-steps { display: flex; flex-direction: column; gap: 20px; }
        .m-step { background: #fff; padding: clamp(20px, 3vw, 30px); border-radius: 16px; border: 1px solid var(--border-light); display: flex; gap: 20px; box-shadow: var(--shadow-sm); transition: border-color 0.4s var(--transition-smooth), box-shadow 0.4s var(--transition-smooth), transform 0.4s var(--transition-smooth); }
        .m-step:hover { transform: translateX(10px); border-color: var(--cyan-neon); box-shadow: var(--shadow-hover); }
        .m-step-num { font-size: clamp(1.8rem, 3vw, 2.2rem); font-weight: 800; color: transparent; -webkit-text-stroke: 1.5px var(--cyan-neon); opacity: 0.7; line-height: 1; min-width: 45px; transition: transform 0.4s var(--ease-spring), opacity 0.4s; }
        .m-step:hover .m-step-num { transform: scale(1.15) rotate(-6deg); opacity: 1; }
        .m-step-content h4 { font-size: clamp(1.1rem, 2vw, 1.2rem); color: var(--navy); margin-bottom: 8px; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .m-step-content h4 i { color: var(--cyan-neon); font-size: 1.1rem;}
        .m-step-content p { color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; }

        /* === CASE STUDIES === */
        .case-studies-section { padding: clamp(60px, 8vw, 100px) 0; background: var(--bg-secondary); }
        .case-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr)); gap: 30px; margin-top: clamp(30px, 5vw, 50px); }
        .case-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-md); transition: box-shadow 0.4s var(--transition-smooth), border-color 0.4s var(--transition-smooth), transform 0.15s ease-out; border: 1px solid var(--border-light); display: flex; flex-direction: column; transform-style: preserve-3d; will-change: transform; }
        .case-card:hover { border-color: var(--cyan-neon); box-shadow: var(--shadow-hover); }
        .case-image { height: 240px; position: relative; overflow: hidden; }
        .case-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
        .case-card:hover .case-image img { transform: scale(1.05); }
        .case-image::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(11, 15, 37, 0.9) 0%, transparent 100%); pointer-events: none; }
        .case-tag { position: absolute; top: 20px; left: 20px; background: var(--cyan-neon); color: var(--navy); padding: 6px 14px; border-radius: 30px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; z-index: 2; box-shadow: 0 4px 10px rgba(0, 242, 254, 0.3); }
        .case-image h3 { position: absolute; bottom: 20px; left: 20px; color: #fff; font-size: 1.5rem; font-weight: 800; z-index: 2; margin: 0; }
        .case-content { padding: clamp(25px, 4vw, 35px); flex: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .case-metrics { display: flex; gap: 15px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--border-light); flex-wrap: wrap;}
        .metric-box { flex: 1; min-width: 110px; background: var(--bg-secondary); padding: 12px; border-radius: 12px;}
        .metric { font-size: clamp(1.4rem, 3vw, 1.8rem); font-weight: 800; color: var(--magenta-neon); display: block; line-height: 1; margin-bottom: 5px; }
        .metric-label { font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }
        .case-content p { color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin: 0; }

        /* === TESTIMONIALS === */
        .testimonials-section { padding: clamp(60px, 8vw, 100px) 0; background: #fff; }
        .testimonials-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr)); gap: 30px; margin-top: clamp(30px, 5vw, 50px); }
        .testi-card { background: #fff; padding: clamp(25px, 5vw, 40px); border-radius: 20px; border: 1px solid var(--border-light); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; justify-content: space-between; transition: box-shadow 0.4s var(--transition-smooth), border-color 0.4s var(--transition-smooth), transform 0.15s ease-out; transform-style: preserve-3d; will-change: transform; }
        .testi-card:hover { border-color: var(--cyan-neon); box-shadow: var(--shadow-hover); }
        .testi-stars { color: #F59E0B; font-size: 1.2rem; margin-bottom: 20px; letter-spacing: 2px; }
        .testi-text { font-size: clamp(0.95rem, 1.5vw, 1.05rem); color: var(--navy); line-height: 1.7; margin-bottom: 30px; font-weight: 400; font-style: italic; }
        .testi-author { display: flex; align-items: center; gap: 15px; border-top: 1px solid var(--border-light); padding-top: 20px; }
        .testi-avatar { width: 50px; height: 50px; border-radius: 50%; overflow: hidden; background: var(--bg-secondary); flex-shrink: 0;}
        .testi-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .testi-author-info h5 { font-size: 1.05rem; color: var(--navy); font-weight: 700; margin-bottom: 3px; }
        .testi-author-info span { font-size: 0.85rem; color: var(--text-muted); font-weight: 500; }

        /* === UPGRADED REALISTIC IMAGE INDUSTRIES === */
        .industries-section { padding: clamp(60px, 8vw, 100px) 0; background: var(--bg-secondary); }
        .industries-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 250px), 1fr)); gap: 25px; margin-top: clamp(30px, 5vw, 50px); }
        .industry-card { position: relative; height: 240px; border-radius: 20px; overflow: hidden; box-shadow: var(--shadow-sm); transition: box-shadow 0.4s var(--transition-smooth), transform 0.15s ease-out; cursor: pointer; transform-style: preserve-3d; will-change: transform; }
        .industry-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }

        .industry-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(11,15,37,0.9) 0%, rgba(11,15,37,0.2) 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 25px 20px; transition: var(--transition-smooth); }
        .industry-card:hover img { transform: scale(1.08); }
        .industry-card:hover .industry-overlay { background: linear-gradient(to top, rgba(0, 242, 254, 0.85) 0%, rgba(11,15,37,0.3) 100%); }

        .industry-overlay i { color: var(--cyan-neon); font-size: 2rem; margin-bottom: 12px; transition: var(--transition-smooth); transform: translateZ(20px); }
        .industry-card:hover .industry-overlay i { color: var(--navy); transform: translateZ(20px) translateY(-5px) scale(1.1); }
        .industry-overlay h5 { color: #fff; font-size: 1.15rem; font-weight: 700; margin: 0; transition: var(--transition-smooth); }
        .industry-card:hover .industry-overlay h5 { color: var(--navy); }

        /* === CTA SECTION === */
        .cta-section { padding: clamp(60px, 8vw, 120px) 0; background: #ffffff; }
        .cta-box { background: var(--navy); border-radius: 30px; max-width: 1000px; width: 100%; margin: 0 auto; padding: clamp(40px, 6vw, 80px) clamp(20px, 5vw, 50px); text-align: center; color: #fff; box-shadow: var(--shadow-hover); position: relative; overflow: hidden; border: 1px solid rgba(0, 242, 254, 0.2); }
        .cta-box::before { content: ''; position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 60%; height: 3px; background: linear-gradient(90deg, transparent, var(--cyan-neon), var(--magenta-neon), transparent); }
        .cta-glow { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 900px; height: 500px; background: radial-gradient(ellipse, rgba(0,242,254,0.16), transparent 65%); pointer-events: none; }
        .cta-badge { display: inline-block; background: rgba(0, 242, 254, 0.1); color: var(--cyan-neon); border: 1px solid rgba(0, 242, 254, 0.2); padding: 8px 18px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 20px; position: relative; z-index: 2; }
        .cta-box h2 { font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; letter-spacing: -1px; margin-bottom: 20px; position: relative; z-index: 2; }
        .cta-box p { margin-bottom: 40px; font-size: clamp(0.95rem, 2vw, 1.15rem); color: rgba(255,255,255,0.7); max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.6; position: relative; z-index: 2; }
        .cta-features { display: flex; justify-content: center; gap: clamp(10px, 2vw, 30px); margin-bottom: 40px; font-weight: 600; font-size: clamp(0.8rem, 1.5vw, 0.95rem); flex-wrap: wrap; position: relative; z-index: 2; }
        .cta-features span { display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.05); padding: 8px 16px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); }
        .cta-btn-wrapper { position: relative; z-index: 2; }

        /* === SCROLL PROGRESS === */
        .scroll-progress { position: fixed; top: 0; left: 0; height: 3px; width: 0%; background: linear-gradient(90deg, var(--cyan-neon), var(--magenta-neon)); z-index: 2000; transition: width 0.1s linear; }

        /* === TABLET & MOBILE OVERRIDES === */
        @media(max-width: 1200px) {
            .mobile-btn { display: block; }
            .nav-menu {
                position: absolute; top: 100%; left: 0; width: 100%;
                background: #0B0F25; flex-direction: column; gap: 0;
                border-bottom: 1px solid rgba(0, 242, 254, 0.2);
                max-height: 0; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.5);
                transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .nav-menu.active { max-height: 600px; padding: 10px 0; overflow-y: auto; }
            .nav-menu li { width: 100%; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.05); }
            .nav-menu li:last-child { border-bottom: none; }
            .nav-menu li a { display: block; padding: 15px; color: #fff; font-size: 1.05rem; }
            .nav-menu li a::after { display: none; }
            .nav-menu li a:hover { background: rgba(0, 242, 254, 0.08); color: var(--cyan-neon); }

            /* Mobile Dropdown Fix */
            .dropdown-menu {
                position: relative; top: auto; left: auto; background: rgba(0,0,0,0.3);
                border: none; box-shadow: none; opacity: 1; visibility: visible; transform: none;
                max-height: 0; overflow: hidden; transition: max-height 0.3s ease; padding: 0;
            }
            .dropdown.active .dropdown-menu { max-height: 400px; padding: 5px 0; }
            .dropdown-menu li a { padding: 12px 20px; text-align: center; }
            .nav-cta { display: none; }
        }

        @media(max-width: 768px) {
            .cinematic-wrapper { height: 100vh; min-height: 550px; padding: 0; perspective: none; }
            .devices-stage { transform: none !important; width: 100%; height: auto; display: flex; flex-direction: column; justify-content: center; align-items: center; }
            .stage-header { position: relative !important; top: auto !important; left: auto !important; opacity: 1 !important; transform: none !important; display: block !important; padding: 0 5%; margin-bottom: 20px; }
            .laptop-container, .scatter-item { display: none !important; }
            .mobile-container { position: relative !important; top: auto !important; left: auto !important; transform: none !important; margin: 0 auto; width: 220px; height: 420px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
            .mobile-perf-overview { display: block; }
        }

        /* === RESPONSIVE FIXES FOR ABOUT & METHODOLOGY SECTIONS === */
        @media(max-width: 1024px) {
            .agency-grid, .methodology-grid {
                grid-template-columns: 1fr !important;
                gap: 40px !important;
            }
            .methodology-image {
                min-height: 350px !important;
                order: -1 !important;
            }
        }

        @media(max-width: 768px) {
            .agency-grid, .methodology-grid {
                grid-template-columns: 1fr !important;
                gap: 30px !important;
            }
            .agency-text h2, .section-header h2 {
                font-size: 1.8rem !important;
            }
            .m-step {
                flex-direction: column !important;
                gap: 15px !important;
                align-items: flex-start !important;
                text-align: left !important;
            }
        }
    </style>
</head>
<body>

    <div class="scroll-progress" id="scrollProgress"></div>

    <!-- HEADER (Solid Dark Theme, No Blur) -->
    <header>
        <div class="container nav-wrapper">
            <a href="index.php" class="logo" style="display: flex; align-items: center;">
                <img src="images/logo-ws.svg" alt="W&S Digital Marketing Logo" class="logo-img">
            </a>

            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="index.php" onclick="toggleMenu()">Home</a></li>
                    <li><a href="about.php" onclick="toggleMenu()">About Us</a></li>

                    <!-- SERVICES DROPDOWN -->
                    <li class="dropdown" onclick="toggleDropdown(event)">
                        <a href="services.php">Services <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; margin-left: 4px;"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="services.php#seo">Search Engine Optimization</a></li>
                            <li><a href="services.php#ecom">E-commerce</a></li>
                            <li><a href="services.php#web">Website Development & Design</a></li>
                            <li><a href="services.php#social">Social Media</a></li>
                            <li><a href="services.php#ppc">PPC Advertising</a></li>
                            <li><a href="services.php#graphic">Graphic Design</a></li>
                            <li><a href="services.php#content">Content Writing</a></li>
                        </ul>
                    </li>

                    <li><a href="index.php#case-studies" onclick="toggleMenu()">Case Studies</a></li>

                    <!-- AGENCY DROPDOWN -->
                    <li class="dropdown" onclick="toggleDropdown(event)">
                        <a href="#agency">Agency <i class="fa-solid fa-chevron-down" style="font-size: 0.75rem; margin-left: 4px;"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="about.php#team">Our Team</a></li>
                            <li><a href="blog.php">Blog</a></li>
                            <li><a href="pricing.php">Pricing Plans</a></li>
                            <li><a href="faq.php">FAQ</a></li>
                        </ul>
                    </li>

                    <li><a href="industries.php" onclick="toggleMenu()">Industries</a></li>
                    <li><a href="contact.php" onclick="toggleMenu()">Contact Us</a></li>
                </ul>
            </nav>
            <div class="nav-cta">
                <a href="index.php#contact" class="header-cta">GET FREE PLAN</a>
            </div>

            <!-- Mobile Menu Button -->
            <button class="mobile-btn" onclick="toggleMenu()"><i class="fa-solid fa-bars"></i></button>
        </div>
    </header>

    <script>
        function toggleDropdown(e) {
            if (window.innerWidth <= 1200) {
                e.currentTarget.classList.toggle('active');
            }
        }
    </script>
