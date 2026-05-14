<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\PomodoroSession;
use Filament\Widgets\Widget;

class PomodoroWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.pomodoro-widget';

    protected int|string|array $columnSpan = ['lg' => 2];

    public function getTodaySessions(): int
    {
        return PomodoroSession::where('user_id', auth()->id())
            ->whereDate('completed_at', today())
            ->count();
    }

    public function getTotalFocusToday(): string
    {
        $minutes = PomodoroSession::where('user_id', auth()->id())
            ->whereDate('completed_at', today())
            ->sum('duration_minutes');

        $h = floor($minutes / 60);
        $m = $minutes % 60;

        return $h > 0 ? "{$h}h {$m}min" : "{$m}min";
    }
}
