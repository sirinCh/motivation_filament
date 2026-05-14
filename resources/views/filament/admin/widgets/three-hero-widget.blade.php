<x-filament-widgets::widget>
    @php
        $stats = [
            [
                'icon' => 'heroicon-m-check-circle',
                'color' => 'text-primary-light',
                'bg' => 'rgba(108,92,231,0.2)',
                'label' => 'Tâches terminées',
                'value' => '24',
                'change' => '+12%',
                'changeType' => 'up',
                'accent' => 'stat-accent-purple',
            ],
            [
                'icon' => 'heroicon-m-clock',
                'color' => 'text-success',
                'bg' => 'rgba(0,184,148,0.2)',
                'label' => 'Temps focus cette semaine',
                'value' => '6.5h',
                'change' => '+8%',
                'changeType' => 'up',
                'accent' => 'stat-accent-success',
            ],
            [
                'icon' => 'heroicon-m-fire',
                'color' => 'text-accent',
                'bg' => 'rgba(253,121,168,0.2)',
                'label' => 'Streak actuel',
                'value' => '12',
                'change' => '+3',
                'changeType' => 'up',
                'accent' => 'stat-accent-warning',
            ],
            [
                'icon' => 'heroicon-m-trophy',
                'color' => 'text-warning',
                'bg' => 'rgba(243,156,18,0.2)',
                'label' => 'Score productivité',
                'value' => '87%',
                'change' => '-2%',
                'changeType' => 'down',
                'accent' => 'stat-accent-danger',
            ],
        ];
    @endphp

    <div class="flex justify-between flex-col md:flex-row w-full gap-8 p-4">
        @foreach ($stats as $stat)
            <div class="glass-card {{ $stat['accent'] }} p-5 relative overflow-hidden w-full md:w-1/4">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-[42px] h-[42px] rounded-xl flex items-center justify-center text-lg"
                        style="background: {{ $stat['bg'] }};">
                        <x-dynamic-component :component="$stat['icon']" class="{{ $stat['color'] }}"
                            style="width:20px;height:20px;" />
                    </div>
                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full"
                        style="background: {{ $stat['changeType'] === 'up' ? 'rgba(0,184,148,0.15)' : 'rgba(231,76,60,0.15)' }}; color: {{ $stat['changeType'] === 'up' ? '#00b894' : '#e74c3c' }};">
                        {{ $stat['change'] }}
                    </span>
                </div>
                <div class="text-[28px] font-extrabold" style="color: #ffffff;">{{ $stat['value'] }}</div>
                <div class="text-xs mt-0.5 font-medium" style="color: rgba(255,255,255,0.4);">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
