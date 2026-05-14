<x-filament-panels::page>
    @php
        $stats = $this->getTodayStats();
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Timer Card --}}
        <div class="lg:col-span-2 rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-8 text-center">
            <div class="text-sm font-medium text-white/60 mb-4" id="pomoLabel">Session de Focus</div>

            <div class="text-7xl font-black tracking-tight mb-6 font-mono"
                 style="background: linear-gradient(135deg, #e74c3c, #f39c12); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"
                 id="pomoTimer"
            >
                25:00
            </div>

            <div class="flex items-center justify-center gap-3 mb-6">
                <button type="button"
                        id="pomoStartBtn"
                        class="px-6 py-3 rounded-xl font-bold text-white transition-all hover:-translate-y-0.5 hover:shadow-lg"
                        style="background: linear-gradient(135deg, #e74c3c, #f39c12);"
                        onclick="togglePomodoro()"
                >
                    <span id="btnText">▶ Démarrer</span>
                </button>

                <button type="button"
                        class="px-6 py-3 rounded-xl font-semibold text-white/60 border border-white/10 bg-white/5 hover:bg-white/10 transition-all"
                        onclick="resetPomodoro()"
                >
                    ↺ Reset
                </button>
            </div>

            <div class="flex items-center justify-center gap-2">
                <button onclick="setPomoMode(25, this)" class="mode-btn px-4 py-2 rounded-full text-xs font-bold bg-white/10 text-white/70 border border-white/10 hover:bg-violet-500/30 hover:border-violet-500/50 hover:text-white transition-all active-mode" data-min="25">25 min</button>
                <button onclick="setPomoMode(15, this)" class="mode-btn px-4 py-2 rounded-full text-xs font-bold bg-white/10 text-white/70 border border-white/10 hover:bg-violet-500/30 hover:border-violet-500/50 hover:text-white transition-all" data-min="15">15 min</button>
                <button onclick="setPomoMode(5, this)" class="mode-btn px-4 py-2 rounded-full text-xs font-bold bg-white/10 text-white/70 border border-white/10 hover:bg-violet-500/30 hover:border-violet-500/50 hover:text-white transition-all" data-min="5">5 min pause</button>
            </div>
        </div>

        {{-- Stats Card --}}
        <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-8">
            <h3 class="text-base font-bold text-white mb-6 flex items-center gap-2">
                <x-heroicon-o-chart-bar class="w-5 h-5 text-emerald-400" />
                Sessions Aujourd'hui
            </h3>

            <div class="text-center">
                <div class="text-5xl font-black text-emerald-400 mb-1" id="sessionCount">{{ $stats['count'] }}</div>
                <div class="text-sm text-white/50 mb-6">sessions complétées</div>

                <div class="text-sm text-white/70">
                    ⏱️ Total focus :
                    <strong class="text-emerald-400" id="totalTime">{{ $stats['total_formatted'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <script>
        let pomoTime = 25 * 60;
        let pomoOriginal = 25 * 60;
        let pomoInterval = null;
        let pomoRunning = false;
        let currentType = 'focus';

        function updateDisplay() {
            const m = Math.floor(pomoTime / 60);
            const s = pomoTime % 60;
            document.getElementById('pomoTimer').textContent =
                String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }

        function togglePomodoro() {
            if (pomoRunning) {
                clearInterval(pomoInterval);
                pomoRunning = false;
                document.getElementById('btnText').textContent = '▶ Reprendre';
                document.getElementById('pomoStartBtn').style.opacity = '0.8';
            } else {
                pomoRunning = true;
                document.getElementById('btnText').textContent = '⏸ Pause';
                document.getElementById('pomoStartBtn').style.opacity = '1';
                pomoInterval = setInterval(() => {
                    pomoTime--;
                    updateDisplay();
                    if (pomoTime <= 0) {
                        clearInterval(pomoInterval);
                        pomoRunning = false;
                        const duration = pomoOriginal / 60;
                        @this.saveSession(duration, currentType);
                        document.getElementById('btnText').textContent = '▶ Démarrer';
                        pomoTime = pomoOriginal;
                        updateDisplay();
                    }
                }, 1000);
            }
        }

        function resetPomodoro() {
            clearInterval(pomoInterval);
            pomoRunning = false;
            pomoTime = pomoOriginal;
            updateDisplay();
            document.getElementById('btnText').textContent = '▶ Démarrer';
            document.getElementById('pomoStartBtn').style.opacity = '1';
        }

        function setPomoMode(min, btn) {
            document.querySelectorAll('.mode-btn').forEach(b => {
                b.classList.remove('bg-violet-500', 'text-white', 'border-violet-500/50');
                b.classList.add('bg-white/10', 'text-white/70', 'border-white/10');
            });
            btn.classList.remove('bg-white/10', 'text-white/70', 'border-white/10');
            btn.classList.add('bg-violet-500', 'text-white', 'border-violet-500/50');

            pomoOriginal = min * 60;
            pomoTime = pomoOriginal;
            updateDisplay();
            resetPomodoro();

            const label = document.getElementById('pomoLabel');
            label.textContent = min >= 25 ? 'Session de Focus' : (min >= 15 ? 'Session Courte' : 'Pause ☕');
            currentType = min >= 25 ? 'focus' : (min >= 15 ? 'focus' : 'short_break');
        }

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('session-saved', () => {
                const countEl = document.getElementById('sessionCount');
                const totalEl = document.getElementById('totalTime');
                let count = parseInt(countEl.textContent) + 1;
                countEl.textContent = count;

                // Approximation du temps total (on ajoute la durée de la session terminée)
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

        // Marquer le bouton 25min comme actif par défaut
        document.querySelector('[data-min="25"]').classList.remove('bg-white/10', 'text-white/70', 'border-white/10');
        document.querySelector('[data-min="25"]').classList.add('bg-violet-500', 'text-white', 'border-violet-500/50');
    </script>

    <style>
        .active-mode {
            background: linear-gradient(135deg, #6c5ce7, #4a3db5) !important;
            color: white !important;
            border-color: rgba(108,92,231,0.5) !important;
        }
    </style>
</x-filament-panels::page>
