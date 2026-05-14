<x-filament-panels::page>
    @php
        $stats = $this->getTodayStats();
    @endphp

    <div class="pomo-wrapper grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===== TIMER CARD ===== --}}
        <div class="pomo-timer-card lg:col-span-2">

            {{-- Mode tabs --}}
            <div class="pomo-modes">
                <button onclick="setPomoMode(25, this)" class="pomo-mode-btn pomo-mode-active" data-min="25" data-type="focus">
                    <span class="pomo-mode-dot" style="background:#e74c3c;"></span> Focus
                </button>
                <button onclick="setPomoMode(15, this)" class="pomo-mode-btn" data-min="15" data-type="short">
                    <span class="pomo-mode-dot" style="background:#a29bfe;"></span> Court
                </button>
                <button onclick="setPomoMode(5, this)" class="pomo-mode-btn" data-min="5" data-type="break">
                    <span class="pomo-mode-dot" style="background:#00b894;"></span> Pause
                </button>
            </div>

            {{-- Label --}}
            <div class="pomo-session-label" id="pomoLabel">Session de Focus</div>

            {{-- SVG Circle + Timer --}}
            <div class="pomo-ring-wrap">
                <svg class="pomo-ring" viewBox="0 0 240 240">
                    {{-- Track --}}
                    <circle class="pomo-ring-track" cx="120" cy="120" r="108"/>
                    {{-- Progress --}}
                    <circle class="pomo-ring-progress" id="pomoRing" cx="120" cy="120" r="108"
                        stroke-dasharray="678.6"
                        stroke-dashoffset="0"
                    />
                    {{-- Glow copy --}}
                    <circle class="pomo-ring-glow" id="pomoRingGlow" cx="120" cy="120" r="108"
                        stroke-dasharray="678.6"
                        stroke-dashoffset="0"
                    />
                </svg>

                <div class="pomo-ring-inner">
                    <div class="pomo-timer-display" id="pomoTimer">25:00</div>
                    <div class="pomo-timer-sub" id="pomoStatus">Prêt</div>
                </div>
            </div>

            {{-- Controls --}}
            <div class="pomo-controls">
                <button type="button" id="pomoStartBtn" class="pomo-btn-start" onclick="togglePomodoro()">
                    <svg id="btnIcon" class="pomo-btn-icon" viewBox="0 0 24 24" fill="currentColor">
                        <polygon points="5,3 19,12 5,21"/>
                    </svg>
                    <span id="btnText">Démarrer</span>
                </button>

                <button type="button" class="pomo-btn-reset" onclick="resetPomodoro()">
                    <svg class="pomo-btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                        <path d="M3 3v5h5"/>
                    </svg>
                    Reset
                </button>
            </div>
        </div>

        {{-- ===== STATS CARD ===== --}}
        <div class="pomo-stats-card">
            <div class="pomo-stats-header">
                <div class="pomo-stats-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                        <path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>
                    </svg>
                </div>
                Sessions Aujourd'hui
            </div>

            {{-- Big count --}}
            <div class="pomo-stats-count-wrap">
                <div class="pomo-stats-count" id="sessionCount">{{ $stats['count'] }}</div>
                <div class="pomo-stats-count-label">sessions complétées</div>
            </div>

            {{-- Progress rings for goal (target: 8 sessions) --}}
            <div class="pomo-goal-wrap">
                @php $pct = min(100, ($stats['count'] / 8) * 100); $circ = 2 * M_PI * 36; @endphp
                <svg class="pomo-goal-ring" viewBox="0 0 88 88">
                    <circle cx="44" cy="44" r="36" class="pomo-goal-track"/>
                    <circle cx="44" cy="44" r="36" class="pomo-goal-progress"
                        stroke-dasharray="{{ $circ }}"
                        stroke-dashoffset="{{ $circ * (1 - $pct / 100) }}"
                    />
                </svg>
                <div class="pomo-goal-inner">
                    <div class="pomo-goal-pct">{{ round($pct) }}%</div>
                    <div class="pomo-goal-label">objectif</div>
                </div>
            </div>

            {{-- Time stat --}}
            <div class="pomo-time-stat">
                <div class="pomo-time-stat-icon">⏱</div>
                <div>
                    <div class="pomo-time-stat-label">Temps total focus</div>
                    <div class="pomo-time-stat-value" id="totalTime">{{ $stats['total_formatted'] }}</div>
                </div>
            </div>

            {{-- Streak dots (visual only, last 8 slots) --}}
            <div class="pomo-dots-wrap">
                <div class="pomo-dots-label">Progression objectif (8)</div>
                <div class="pomo-dots">
                    @for($i = 0; $i < 8; $i++)
                        <div class="pomo-dot {{ $i < $stats['count'] ? 'pomo-dot-done' : '' }}"></div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <script>
        // ===== STATE =====
        let pomoTime = 25 * 60;
        let pomoOriginal = 25 * 60;
        let pomoInterval = null;
        let pomoRunning = false;
        let currentType = 'focus';
        const CIRCUMFERENCE = 678.6;

        // ===== COLORS per mode =====
        const modeColors = {
            focus: { start: '#e74c3c', end: '#f39c12', glow: '#e74c3c' },
            short: { start: '#a29bfe', end: '#6c5ce7', glow: '#6c5ce7' },
            break: { start: '#00b894', end: '#00cec9', glow: '#00b894' },
        };
        let currentMode = 'focus';

        function applyModeColor(mode) {
            const c = modeColors[mode];
            const ring = document.getElementById('pomoRing');
            const ringGlow = document.getElementById('pomoRingGlow');
            const timer = document.getElementById('pomoTimer');
            const startBtn = document.getElementById('pomoStartBtn');
            ring.style.stroke = `url(#pomoGrad-${mode})`;
            ringGlow.style.stroke = c.glow;
            timer.style.backgroundImage = `linear-gradient(135deg, ${c.start}, ${c.end})`;
            startBtn.style.backgroundImage = `linear-gradient(135deg, ${c.start}, ${c.end})`;
            startBtn.style.boxShadow = `0 8px 30px ${c.glow}55`;
        }

        function updateRing() {
            const pct = pomoTime / pomoOriginal;
            const offset = CIRCUMFERENCE * (1 - pct);
            document.getElementById('pomoRing').style.strokeDashoffset = offset;
            document.getElementById('pomoRingGlow').style.strokeDashoffset = offset;
        }

        function updateDisplay() {
            const m = Math.floor(pomoTime / 60);
            const s = pomoTime % 60;
            document.getElementById('pomoTimer').textContent =
                String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            updateRing();
        }

        function togglePomodoro() {
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');
            if (pomoRunning) {
                clearInterval(pomoInterval);
                pomoRunning = false;
                btnText.textContent = 'Reprendre';
                btnIcon.innerHTML = '<polygon points="5,3 19,12 5,21"/>';
                document.getElementById('pomoStatus').textContent = 'En pause';
                document.getElementById('pomoStartBtn').classList.remove('pomo-btn-running');
            } else {
                pomoRunning = true;
                btnText.textContent = 'Pause';
                btnIcon.innerHTML = '<rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/>';
                document.getElementById('pomoStatus').textContent = 'En cours…';
                document.getElementById('pomoStartBtn').classList.add('pomo-btn-running');
                pomoInterval = setInterval(() => {
                    pomoTime--;
                    updateDisplay();
                    if (pomoTime <= 0) {
                        clearInterval(pomoInterval);
                        pomoRunning = false;
                        const duration = pomoOriginal / 60;
                        @this.saveSession(duration, currentType);
                        btnText.textContent = 'Démarrer';
                        btnIcon.innerHTML = '<polygon points="5,3 19,12 5,21"/>';
                        document.getElementById('pomoStatus').textContent = 'Terminé ! 🎉';
                        document.getElementById('pomoStartBtn').classList.remove('pomo-btn-running');
                        pomoTime = pomoOriginal;
                        updateDisplay();
                        // pulse animation
                        document.querySelector('.pomo-ring-wrap').classList.add('pomo-complete-pulse');
                        setTimeout(() => document.querySelector('.pomo-ring-wrap').classList.remove('pomo-complete-pulse'), 1200);
                    }
                }, 1000);
            }
        }

        function resetPomodoro() {
            clearInterval(pomoInterval);
            pomoRunning = false;
            pomoTime = pomoOriginal;
            updateDisplay();
            document.getElementById('btnText').textContent = 'Démarrer';
            document.getElementById('btnIcon').innerHTML = '<polygon points="5,3 19,12 5,21"/>';
            document.getElementById('pomoStatus').textContent = 'Prêt';
            document.getElementById('pomoStartBtn').classList.remove('pomo-btn-running');
        }

        function setPomoMode(min, btn) {
            document.querySelectorAll('.pomo-mode-btn').forEach(b => b.classList.remove('pomo-mode-active'));
            btn.classList.add('pomo-mode-active');
            pomoOriginal = min * 60;
            pomoTime = pomoOriginal;
            currentMode = btn.dataset.type;
            currentType = min >= 25 ? 'focus' : (min >= 15 ? 'focus' : 'short_break');
            applyModeColor(currentMode);
            const label = document.getElementById('pomoLabel');
            label.textContent = min >= 25 ? 'Session de Focus' : (min >= 15 ? 'Session Courte' : 'Pause ☕');
            resetPomodoro();
        }

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('session-saved', () => {
                // 🎉 Confetti on session complete
                if (window.MotivConfetti) window.MotivConfetti.launch();

                const countEl = document.getElementById('sessionCount');
                const totalEl = document.getElementById('totalTime');
                let count = parseInt(countEl.textContent) + 1;
                countEl.textContent = count;
                // update dots
                const dots = document.querySelectorAll('.pomo-dot');
                if (count <= dots.length) dots[count - 1].classList.add('pomo-dot-done');
                // update time
                const addedMin = pomoOriginal / 60;
                const match = totalEl.textContent.match(/(\d+)h\s*(\d+)min|(\d+)min/);
                let totalMin = 0;
                if (match) {
                    if (match[1]) totalMin += parseInt(match[1]) * 60;
                    totalMin += parseInt(match[2] || match[3] || 0);
                }
                totalMin += addedMin;
                const h = Math.floor(totalMin / 60);
                const m = totalMin % 60;
                totalEl.textContent = h > 0 ? h + 'h ' + m + 'min' : m + 'min';
            });
        });

        // Init
        applyModeColor('focus');
        updateRing();
    </script>

    <style>
        /* ===== SVG GRADIENTS ===== */
        .pomo-wrapper {
            --pomo-focus-s: #e74c3c;
            --pomo-focus-e: #f39c12;
            --pomo-short-s: #a29bfe;
            --pomo-short-e: #6c5ce7;
            --pomo-break-s: #00b894;
            --pomo-break-e: #00cec9;
        }

        /* Inject SVG defs inline */
        .pomo-wrapper::before {
            content: '';
            display: none;
        }

        /* ===== TIMER CARD ===== */
        .pomo-timer-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.07), rgba(108,92,231,0.04));
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.08);
        }

        /* ===== MODE TABS ===== */
        .pomo-modes {
            display: flex;
            gap: 0.5rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 50px;
            padding: 4px;
        }

        .pomo-mode-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.5);
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pomo-mode-btn:hover {
            color: rgba(255,255,255,0.8);
            background: rgba(255,255,255,0.06);
        }

        .pomo-mode-btn.pomo-mode-active {
            background: rgba(255,255,255,0.12);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .pomo-mode-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ===== SESSION LABEL ===== */
        .pomo-session-label {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
        }

        /* ===== SVG RING ===== */
        .pomo-ring-wrap {
            position: relative;
            width: 240px;
            height: 240px;
            transition: transform 0.3s ease;
        }

        .pomo-ring {
            width: 240px;
            height: 240px;
            transform: rotate(-90deg);
            overflow: visible;
        }

        .pomo-ring-track {
            fill: none;
            stroke: rgba(255,255,255,0.06);
            stroke-width: 8;
        }

        .pomo-ring-progress {
            fill: none;
            stroke: #e74c3c;
            stroke-width: 8;
            stroke-linecap: round;
            transition: stroke-dashoffset 1s linear, stroke 0.4s ease;
        }

        .pomo-ring-glow {
            fill: none;
            stroke: #e74c3c;
            stroke-width: 14;
            stroke-linecap: round;
            opacity: 0.2;
            filter: blur(4px);
            transition: stroke-dashoffset 1s linear, stroke 0.4s ease;
        }

        .pomo-ring-inner {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .pomo-timer-display {
            font-size: 3.5rem;
            font-weight: 900;
            font-family: 'Courier New', monospace;
            letter-spacing: -2px;
            background-image: linear-gradient(135deg, #e74c3c, #f39c12);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            transition: background-image 0.4s ease;
        }

        .pomo-timer-sub {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
        }

        /* Complete pulse */
        @keyframes pomoPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.06); }
            100% { transform: scale(1); }
        }
        .pomo-complete-pulse {
            animation: pomoPulse 0.6s ease 2;
        }

        /* ===== CONTROLS ===== */
        .pomo-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .pomo-btn-start {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            border: none;
            cursor: pointer;
            background-image: linear-gradient(135deg, #e74c3c, #f39c12);
            box-shadow: 0 8px 30px rgba(231,76,60,0.4);
            transition: transform 0.2s ease, box-shadow 0.3s ease, opacity 0.2s;
        }

        .pomo-btn-start:hover {
            transform: translateY(-2px);
        }

        .pomo-btn-start.pomo-btn-running {
            animation: pomoGlow 2s ease-in-out infinite;
        }

        @keyframes pomoGlow {
            0%, 100% { box-shadow: 0 8px 30px rgba(231,76,60,0.4); }
            50% { box-shadow: 0 8px 50px rgba(231,76,60,0.7); }
        }

        .pomo-btn-reset {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 14px 24px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .pomo-btn-reset:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateY(-1px);
        }

        .pomo-btn-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        /* ===== STATS CARD ===== */
        .pomo-stats-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(0,184,148,0.04));
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.08);
        }

        .pomo-stats-header {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
        }

        .pomo-stats-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, rgba(0,184,148,0.3), rgba(0,206,201,0.15));
            border: 1px solid rgba(0,184,148,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00b894;
            flex-shrink: 0;
        }

        /* Count */
        .pomo-stats-count-wrap {
            text-align: center;
        }

        .pomo-stats-count {
            font-size: 4rem;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #00b894, #00cec9);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .pomo-stats-count-label {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            margin-top: 4px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Goal ring */
        .pomo-goal-wrap {
            position: relative;
            width: 88px;
            height: 88px;
            margin: 0 auto;
        }

        .pomo-goal-ring {
            width: 88px;
            height: 88px;
            transform: rotate(-90deg);
        }

        .pomo-goal-track {
            fill: none;
            stroke: rgba(255,255,255,0.06);
            stroke-width: 7;
        }

        .pomo-goal-progress {
            fill: none;
            stroke: #00b894;
            stroke-width: 7;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.8s ease;
        }

        .pomo-goal-inner {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .pomo-goal-pct {
            font-size: 18px;
            font-weight: 900;
            color: #00b894;
            line-height: 1;
        }

        .pomo-goal-label {
            font-size: 9px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Time stat */
        .pomo-time-stat {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(0,184,148,0.08);
            border: 1px solid rgba(0,184,148,0.2);
            border-radius: 12px;
            padding: 12px 16px;
        }

        .pomo-time-stat-icon {
            font-size: 20px;
        }

        .pomo-time-stat-label {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .pomo-time-stat-value {
            font-size: 20px;
            font-weight: 800;
            color: #00cec9;
            line-height: 1.2;
        }

        /* Dots */
        .pomo-dots-wrap {
            margin-top: auto;
        }

        .pomo-dots-label {
            font-size: 10px;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .pomo-dots {
            display: flex;
            gap: 6px;
        }

        .pomo-dot {
            flex: 1;
            height: 6px;
            border-radius: 3px;
            background: rgba(255,255,255,0.08);
            transition: background 0.4s ease, box-shadow 0.4s ease;
        }

        .pomo-dot-done {
            background: linear-gradient(90deg, #00b894, #00cec9);
            box-shadow: 0 0 8px rgba(0,184,148,0.5);
        }
    </style>

    {{-- SVG gradient defs (hidden) --}}
    <svg width="0" height="0" style="position:absolute">
        <defs>
            <linearGradient id="pomoGrad-focus" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#e74c3c"/>
                <stop offset="100%" stop-color="#f39c12"/>
            </linearGradient>
            <linearGradient id="pomoGrad-short" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#a29bfe"/>
                <stop offset="100%" stop-color="#6c5ce7"/>
            </linearGradient>
            <linearGradient id="pomoGrad-break" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#00b894"/>
                <stop offset="100%" stop-color="#00cec9"/>
            </linearGradient>
        </defs>
    </svg>

</x-filament-panels::page>
