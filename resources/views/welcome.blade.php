<x-guest-layout>
    <x-slot name="title">Bienvenue</x-slot>

    @push('head::start')
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #0a0a1a;
            color: rgba(255,255,255,0.9);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(108,92,231,0.4); border-radius: 3px; }

        /* ===== CANVAS ===== */
        #welcome-canvas {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* ===== LAYOUT ===== */
        .w-page { position: relative; z-index: 1; }

        /* ===== NAV ===== */
        .w-nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 40px;
            background: rgba(10,10,26,0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .w-nav-logo {
            font-size: 1.4rem;
            font-weight: 900;
            background: linear-gradient(135deg, #a29bfe, #fd79a8);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .w-nav-logo span { opacity: 0.7; }

        .w-nav-cta {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .w-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .w-btn-outline {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.8);
        }

        .w-btn-outline:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .w-btn-primary {
            background: linear-gradient(135deg, #6c5ce7, #fd79a8);
            color: #fff;
            box-shadow: 0 4px 20px rgba(108,92,231,0.4);
        }

        .w-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(108,92,231,0.6);
        }

        /* ===== HERO ===== */
        .w-hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 24px 80px;
        }

        .w-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            background: rgba(108,92,231,0.15);
            border: 1px solid rgba(108,92,231,0.3);
            color: #a29bfe;
            margin-bottom: 32px;
            animation: fadeUp 0.6s ease forwards;
        }

        .w-hero-badge-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6c5ce7, #fd79a8);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.3); }
        }

        .w-hero-title {
            font-size: clamp(2.8rem, 7vw, 5.5rem);
            font-weight: 900;
            line-height: 1.05;
            letter-spacing: -2px;
            margin-bottom: 24px;
            animation: fadeUp 0.7s ease 0.1s both;
        }

        .w-hero-title .line-1 {
            display: block;
            color: rgba(255,255,255,0.9);
        }

        .w-hero-title .line-2 {
            display: block;
            background: linear-gradient(135deg, #a29bfe, #fd79a8);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .w-hero-sub {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: rgba(255,255,255,0.5);
            max-width: 560px;
            line-height: 1.7;
            margin-bottom: 44px;
            animation: fadeUp 0.7s ease 0.2s both;
        }

        .w-hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeUp 0.7s ease 0.3s both;
        }

        .w-hero-actions .w-btn {
            padding: 14px 32px;
            font-size: 16px;
        }

        .w-hero-scroll {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.25);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            animation: fadeUp 1s ease 0.8s both;
        }

        .w-hero-scroll-line {
            width: 1px;
            height: 40px;
            background: linear-gradient(180deg, transparent, rgba(108,92,231,0.5));
            animation: scrollLine 2s ease-in-out infinite;
        }

        @keyframes scrollLine {
            0%, 100% { opacity: 0.3; transform: scaleY(0.5); transform-origin: top; }
            50% { opacity: 1; transform: scaleY(1); }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== FEATURES ===== */
        .w-features {
            padding: 100px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .w-section-label {
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #a29bfe;
            margin-bottom: 16px;
        }

        .w-section-title {
            text-align: center;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 900;
            letter-spacing: -1px;
            color: rgba(255,255,255,0.9);
            margin-bottom: 12px;
        }

        .w-section-title span {
            background: linear-gradient(135deg, #a29bfe, #fd79a8);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .w-section-sub {
            text-align: center;
            color: rgba(255,255,255,0.45);
            font-size: 1rem;
            max-width: 500px;
            margin: 0 auto 64px;
            line-height: 1.7;
        }

        .w-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
        }

        .w-feature-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.07), rgba(108,92,231,0.03));
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 32px 28px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .w-feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        }

        .w-feature-card:hover {
            transform: translateY(-6px);
            border-color: rgba(108,92,231,0.35);
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 40px rgba(108,92,231,0.08);
            background: linear-gradient(135deg, rgba(255,255,255,0.09), rgba(108,92,231,0.06));
        }

        .w-feature-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .w-feature-icon-purple {
            background: linear-gradient(135deg, rgba(108,92,231,0.3), rgba(162,155,254,0.15));
            border: 1px solid rgba(108,92,231,0.3);
        }

        .w-feature-icon-pink {
            background: linear-gradient(135deg, rgba(253,121,168,0.3), rgba(253,121,168,0.1));
            border: 1px solid rgba(253,121,168,0.3);
        }

        .w-feature-icon-teal {
            background: linear-gradient(135deg, rgba(0,206,201,0.3), rgba(0,184,148,0.15));
            border: 1px solid rgba(0,206,201,0.3);
        }

        .w-feature-icon-amber {
            background: linear-gradient(135deg, rgba(253,203,110,0.3), rgba(243,156,18,0.15));
            border: 1px solid rgba(253,203,110,0.3);
        }

        .w-feature-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
            margin-bottom: 10px;
        }

        .w-feature-desc {
            font-size: 14px;
            color: rgba(255,255,255,0.45);
            line-height: 1.65;
        }

        .w-feature-tag {
            display: inline-block;
            margin-top: 16px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .w-tag-purple { background: rgba(108,92,231,0.15); color: #a29bfe; border: 1px solid rgba(108,92,231,0.25); }
        .w-tag-pink   { background: rgba(253,121,168,0.15); color: #fd79a8; border: 1px solid rgba(253,121,168,0.25); }
        .w-tag-teal   { background: rgba(0,206,201,0.15);  color: #00cec9; border: 1px solid rgba(0,206,201,0.25); }
        .w-tag-amber  { background: rgba(253,203,110,0.15); color: #fdcb6e; border: 1px solid rgba(253,203,110,0.25); }

        /* ===== STATS STRIP ===== */
        .w-stats {
            padding: 60px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .w-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            overflow: hidden;
            backdrop-filter: blur(20px);
        }

        .w-stat {
            padding: 40px 32px;
            text-align: center;
            background: linear-gradient(135deg, rgba(255,255,255,0.04), rgba(108,92,231,0.02));
            transition: background 0.3s ease;
        }

        .w-stat:hover {
            background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(108,92,231,0.06));
        }

        .w-stat-value {
            font-size: 2.8rem;
            font-weight: 900;
            letter-spacing: -2px;
            background: linear-gradient(135deg, #a29bfe, #fd79a8);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: 10px;
        }

        .w-stat-label {
            font-size: 13px;
            color: rgba(255,255,255,0.45);
            font-weight: 500;
        }

        /* ===== CTA SECTION ===== */
        .w-cta {
            padding: 100px 40px;
            text-align: center;
            position: relative;
        }

        .w-cta-card {
            max-width: 700px;
            margin: 0 auto;
            background: linear-gradient(135deg, rgba(108,92,231,0.15), rgba(253,121,168,0.08));
            border: 1px solid rgba(108,92,231,0.25);
            border-radius: 28px;
            padding: 64px 48px;
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            position: relative;
            overflow: hidden;
        }

        .w-cta-card::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(108,92,231,0.15), transparent 70%);
        }

        .w-cta-card::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(253,121,168,0.12), transparent 70%);
        }

        .w-cta-title {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            font-weight: 900;
            letter-spacing: -1px;
            color: rgba(255,255,255,0.95);
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .w-cta-title span {
            background: linear-gradient(135deg, #a29bfe, #fd79a8);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .w-cta-sub {
            color: rgba(255,255,255,0.5);
            font-size: 1rem;
            line-height: 1.7;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .w-cta-actions {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .w-cta-actions .w-btn {
            padding: 16px 36px;
            font-size: 16px;
        }

        /* ===== FOOTER ===== */
        .w-footer {
            padding: 32px 40px;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .w-footer-logo {
            font-size: 1.1rem;
            font-weight: 800;
            background: linear-gradient(135deg, #a29bfe, #fd79a8);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .w-footer-copy {
            font-size: 13px;
            color: rgba(255,255,255,0.25);
        }

        .w-footer-link {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .w-footer-link:hover { color: #a29bfe; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .w-nav { padding: 14px 20px; }
            .w-features, .w-stats, .w-cta { padding-left: 20px; padding-right: 20px; }
            .w-hero { padding-left: 20px; padding-right: 20px; }
            .w-cta-card { padding: 48px 28px; }
            .w-footer { padding: 24px 20px; justify-content: center; text-align: center; }
        }
    </style>
    @endpush

    @push('head::scripts')
    <script src="https://unpkg.com/three@0.158.0/build/three.min.js"></script>
    @endpush

    {{-- Canvas Three.js --}}
    <canvas id="welcome-canvas"></canvas>

    <div class="w-page">

        {{-- NAV --}}
        <nav class="w-nav">
            <a href="{{ url('/') }}" class="w-nav-logo">Motiv<span>Flow</span></a>
            <div class="w-nav-cta">
                <a href="{{ route('filament.admin.auth.login') }}" class="w-btn w-btn-outline">Se connecter</a>
                <a href="{{ route('filament.admin.auth.login') }}" class="w-btn w-btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    Commencer
                </a>
            </div>
        </nav>

        {{-- HERO --}}
        <section class="w-hero">
            <div class="w-hero-badge">
                <span class="w-hero-badge-dot"></span>
                Boostez votre productivité
            </div>

            <h1 class="w-hero-title">
                <span class="line-1">Restez focus.</span>
                <span class="line-2">Atteignez vos objectifs.</span>
            </h1>

            <p class="w-hero-sub">
                MotivFlow réunit Pomodoro, Kanban, suivi d'humeur et statistiques dans un seul espace immersif — conçu pour vous garder dans le flow.
            </p>

            <div class="w-hero-actions">
                <a href="{{ route('filament.admin.auth.login') }}" class="w-btn w-btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    Accéder au tableau de bord
                </a>
                <a href="#features" class="w-btn w-btn-outline">
                    Découvrir les fonctionnalités
                </a>
            </div>

            <div class="w-hero-scroll">
                <div class="w-hero-scroll-line"></div>
                Défiler
            </div>
        </section>

        {{-- FEATURES --}}
        <section class="w-features" id="features">
            <div class="w-section-label">Fonctionnalités</div>
            <h2 class="w-section-title">Tout ce qu'il vous faut pour <span>performer</span></h2>
            <p class="w-section-sub">Des outils pensés pour s'adapter à votre rythme et amplifier votre concentration.</p>

            <div class="w-grid">
                <div class="w-feature-card">
                    <div class="w-feature-icon w-feature-icon-purple">⏱</div>
                    <div class="w-feature-title">Pomodoro Timer</div>
                    <div class="w-feature-desc">Timer visuel avec anneau SVG animé, modes Focus / Pause / Session courte, statistiques quotidiennes et confettis de célébration.</div>
                    <span class="w-feature-tag w-tag-purple">Focus profond</span>
                </div>

                <div class="w-feature-card">
                    <div class="w-feature-icon w-feature-icon-teal">📋</div>
                    <div class="w-feature-title">Kanban Board</div>
                    <div class="w-feature-desc">Glissez-déposez vos tâches entre les colonnes À faire, En cours et Terminé. Priorisez visuellement avec indicateurs de couleur.</div>
                    <span class="w-feature-tag w-tag-teal">Organisation</span>
                </div>

                <div class="w-feature-card">
                    <div class="w-feature-icon w-feature-icon-pink">📊</div>
                    <div class="w-feature-title">Statistiques & Charts</div>
                    <div class="w-feature-desc">Suivez votre humeur, vos sessions de focus, vos objectifs et votre productivité hebdomadaire avec des graphiques interactifs.</div>
                    <span class="w-feature-tag w-tag-pink">Analytics</span>
                </div>

                <div class="w-feature-card">
                    <div class="w-feature-icon w-feature-icon-amber">🎯</div>
                    <div class="w-feature-title">Gestion d'Objectifs</div>
                    <div class="w-feature-desc">Définissez des objectifs clairs, suivez leur progression et recevez des citations motivantes pour garder le cap chaque jour.</div>
                    <span class="w-feature-tag w-tag-amber">Motivation</span>
                </div>
            </div>
        </section>

        {{-- STATS --}}
        <section class="w-stats">
            <div class="w-stats-grid">
                <div class="w-stat">
                    <div class="w-stat-value">25min</div>
                    <div class="w-stat-label">Sessions Pomodoro</div>
                </div>
                <div class="w-stat">
                    <div class="w-stat-value">∞</div>
                    <div class="w-stat-label">Tâches organisées</div>
                </div>
                <div class="w-stat">
                    <div class="w-stat-value">8/j</div>
                    <div class="w-stat-label">Objectif quotidien</div>
                </div>
                <div class="w-stat">
                    <div class="w-stat-value">100%</div>
                    <div class="w-stat-label">Conçu pour vous</div>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="w-cta">
            <div class="w-cta-card">
                <h2 class="w-cta-title">Prêt à entrer dans le <span>flow</span> ?</h2>
                <p class="w-cta-sub">Accédez à votre tableau de bord et commencez dès maintenant à tracker votre productivité, vos humeurs et vos objectifs.</p>
                <div class="w-cta-actions">
                    <a href="{{ route('filament.admin.auth.login') }}" class="w-btn w-btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                        Ouvrir le tableau de bord
                    </a>
                </div>
            </div>
        </section>

        {{-- FOOTER --}}
        <footer class="w-footer">
            <div class="w-footer-logo">MotivFlow</div>
            <div class="w-footer-copy">© {{ date('Y') }} — Tous droits réservés</div>
            <a href="{{ route('filament.admin.auth.login') }}" class="w-footer-link">Connexion →</a>
        </footer>

    </div>

    @push('body::scripts')
    <script>
    (function () {
        const canvas = document.getElementById('welcome-canvas');
        if (!canvas || typeof THREE === 'undefined') return;

        const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0x0a0a1a, 1);

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 30;

        // Particles
        const count = window.innerWidth < 768 ? 600 : 1200;
        const positions = new Float32Array(count * 3);
        const colors = new Float32Array(count * 3);

        const palette = [
            [0.424, 0.361, 0.906], // #6c5ce7
            [0.635, 0.608, 0.996], // #a29bfe
            [0.992, 0.475, 0.659], // #fd79a8
            [0.000, 0.808, 0.788], // #00cec9
        ];

        for (let i = 0; i < count; i++) {
            positions[i * 3]     = (Math.random() - 0.5) * 100;
            positions[i * 3 + 1] = (Math.random() - 0.5) * 100;
            positions[i * 3 + 2] = (Math.random() - 0.5) * 60;
            const c = palette[Math.floor(Math.random() * palette.length)];
            colors[i * 3]     = c[0];
            colors[i * 3 + 1] = c[1];
            colors[i * 3 + 2] = c[2];
        }

        const geo = new THREE.BufferGeometry();
        geo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geo.setAttribute('color', new THREE.BufferAttribute(colors, 3));

        const mat = new THREE.PointsMaterial({
            size: 0.18,
            vertexColors: true,
            transparent: true,
            opacity: 0.55,
            sizeAttenuation: true,
        });

        const points = new THREE.Points(geo, mat);
        scene.add(points);

        // Mouse parallax
        let mx = 0, my = 0;
        window.addEventListener('mousemove', e => {
            mx = (e.clientX / window.innerWidth - 0.5) * 2;
            my = (e.clientY / window.innerHeight - 0.5) * 2;
        });

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        let t = 0;
        function animate() {
            requestAnimationFrame(animate);
            t += 0.0005;
            points.rotation.y = t * 0.4 + mx * 0.04;
            points.rotation.x = t * 0.2 - my * 0.03;
            renderer.render(scene, camera);
        }
        animate();
    })();
    </script>
    @endpush

</x-guest-layout>
