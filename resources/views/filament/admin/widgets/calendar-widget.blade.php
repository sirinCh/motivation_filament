<x-filament-widgets::widget>
    @php
        $data = $this->getCalendarData();
    @endphp

    <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl p-6">
        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
            <x-heroicon-o-calendar class="w-5 h-5 text-violet-400" />
            {{ $data['month_name'] }}
        </h3>

        <div class="grid grid-cols-7 gap-1 mb-2">
            @foreach (['L', 'M', 'M', 'J', 'V', 'S', 'D'] as $dayLabel)
                <div class="text-center text-[10px] font-bold text-white/40 uppercase tracking-wider py-1">
                    {{ $dayLabel }}</div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 gap-1">
            {{-- Empty cells before start --}}
            @for ($i = 0; $i < $data['start_offset']; $i++)
                <div class="aspect-square"></div>
            @endfor

            @for ($day = 1; $day <= $data['days_in_month']; $day++)
                @php
                    $hasTask = in_array($day, $data['task_dates']);
                    $isToday = $day === $data['today'];
                @endphp

                <div
                    class="aspect-square flex items-center justify-center rounded-lg text-xs font-medium relative cursor-pointer transition-colors p-2
                    @if($isToday) bg-violet-500/20 text-white font-bold shadow-lg shadow-violet-500/25
                    @else text-white/70 hover:bg-white/10
                    @endif
                ">
                    {{ $day }}
                    @if ($hasTask && !$isToday)
                        <span class="absolute bottom-1 w-1 h-1 rounded-full bg-amber-400"></span>
                    @endif
                </div>
            @endfor
        </div>

    </div>
</x-filament-widgets::widget>
