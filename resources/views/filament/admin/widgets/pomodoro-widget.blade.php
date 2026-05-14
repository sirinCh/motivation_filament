<x-filament-widgets::widget>
    <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <x-heroicon-o-clock class="w-5 h-5 text-rose-400" />
                Pomodoro Aujourd'hui
            </h3>
            <a href="{{ \App\Filament\Admin\Pages\PomodoroTimerPage::getUrl() }}"
               class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-violet-500/20 text-violet-300 hover:bg-violet-500/30 transition-colors border border-violet-500/30">
                Lancer
            </a>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                <div class="text-3xl font-black text-emerald-400">{{ $this->getTodaySessions() }}</div>
                <div class="text-xs text-white/50 mt-1">sessions</div>
            </div>
            <div class="text-center p-4 rounded-xl bg-white/5 border border-white/10">
                <div class="text-3xl font-black text-violet-400">{{ $this->getTotalFocusToday() }}</div>
                <div class="text-xs text-white/50 mt-1">de focus</div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
