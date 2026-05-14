@php
use App\Enums\TaskStatus;
use App\Models\Task;

$streak = 0;
$date = now()->copy();
while (true) {
    $hasCompleted = Task::where('user_id', auth()->id())
        ->where('status', TaskStatus::Done)
        ->whereDate('completed_at', $date->toDateString())
        ->exists();
    if (! $hasCompleted && ! $date->isToday()) break;
    if ($hasCompleted) $streak++;
    $date->subDay();
}
@endphp

@if($streak > 0)
    <div class="mt-auto mx-3 mb-3 p-4 rounded-2xl border border-amber-500/20 text-center"
         style="background: linear-gradient(135deg, rgba(253,203,110,0.12), rgba(253,121,168,0.08));">
        <div class="text-2xl mb-1 animate-pulse">🔥</div>
        <div class="text-3xl font-black tracking-tight"
             style="background: linear-gradient(135deg, #fdcb6e, #fd79a8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            {{ $streak }}
        </div>
        <div class="text-[11px] text-white/60 font-medium mt-0.5">jours consécutifs</div>
    </div>
@endif
