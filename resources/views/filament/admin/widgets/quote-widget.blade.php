<x-filament-widgets::widget class="fi-wi-quote">
    @php
        $quote = $this->getQuote();
    @endphp

    @if($quote)
        <div
            x-data="{ show: false }"
            x-init="setTimeout(() => show = true, 100)"
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 -translate-y-5"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="relative overflow-hidden rounded-2xl border border-violet-500/20 p-5 flex items-center gap-4"
            style="background: linear-gradient(135deg, rgba(108,92,231,0.15), rgba(253,121,168,0.1));"
        >
            <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full opacity-20" style="background: radial-gradient(circle, rgba(108,92,231,0.3), transparent);"></div>

            <div class="text-3xl opacity-30 flex-shrink-0">💡</div>

            <div class="flex-1 relative z-10">
                <p class="text-sm italic text-white/80 leading-relaxed">"{{ $quote->text }}"</p>
                <p class="text-xs font-semibold mt-1" style="color: #a29bfe;">— {{ $quote->author }}</p>
            </div>
        </div>
    @endif
</x-filament-widgets::widget>
