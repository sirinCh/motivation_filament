<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Enums\PomodoroSessionType;
use App\Models\PomodoroSession;
use Filament\Pages\Page;

final class PomodoroTimerPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Productivité';

    protected static ?int $navigationSort = 7;

    protected static string $view = 'filament.admin.pages.pomodoro-timer';

    public function getTitle(): string
    {
        return 'Pomodoro Timer';
    }

    public function saveSession(int $durationMinutes, string $sessionType): void
    {
        PomodoroSession::create([
            'user_id' => auth()->id(),
            'duration_minutes' => $durationMinutes,
            'started_at' => now()->subMinutes($durationMinutes),
            'completed_at' => now(),
            'session_type' => $sessionType,
        ]);

        $this->dispatch('session-saved');
    }

    public function getTodayStats(): array
    {
        $sessions = PomodoroSession::query()
            ->where('user_id', auth()->id())
            ->whereDate('completed_at', today())
            ->get();

        $count = $sessions->count();
        $totalMinutes = $sessions->sum('duration_minutes');
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return [
            'count' => $count,
            'total_formatted' => $hours > 0 ? "{$hours}h {$minutes}min" : "{$minutes}min",
            'total_minutes' => $totalMinutes,
        ];
    }
}
