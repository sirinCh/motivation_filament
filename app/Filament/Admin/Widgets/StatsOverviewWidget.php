<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Enums\TaskStatus;
use App\Models\PomodoroSession;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = auth()->id();

        $completedTasks = Task::where('user_id', $userId)
            ->where('status', TaskStatus::Done)
            ->count();

        $totalTasks = Task::where('user_id', $userId)->count();

        $focusMinutes = PomodoroSession::where('user_id', $userId)
            ->whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('duration_minutes');
        $focusHours = round($focusMinutes / 60, 1);

        $streak = $this->calculateStreak($userId);

        $productivityScore = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100)
            : 0;

        return [
            Stat::make('Tâches terminées', $completedTasks)
                ->description('+12% cette semaine')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-m-check-circle')
                ->extraAttributes(['class' => 'rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl']),

            Stat::make('Temps focus', $focusHours . 'h')
                ->description('+8% cette semaine')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info')
                ->icon('heroicon-m-clock')
                ->extraAttributes(['class' => 'rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl']),

            Stat::make('Streak actuel', $streak . ' jours')
                ->description('+3 depuis hier')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->icon('heroicon-m-fire')
                ->extraAttributes(['class' => 'rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl']),

            Stat::make('Score productivité', $productivityScore . '%')
                ->description($productivityScore >= 80 ? 'Excellent !' : 'En progression')
                ->descriptionIcon($productivityScore >= 80 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($productivityScore >= 80 ? 'success' : 'danger')
                ->icon('heroicon-m-trophy')
                ->extraAttributes(['class' => 'rounded-2xl border border-white/10 bg-white/5 backdrop-blur-xl']),
        ];
    }

    private function calculateStreak(int $userId): int
    {
        $streak = 0;
        $date = now()->copy();

        while (true) {
            $hasCompletedTask = Task::where('user_id', $userId)
                ->where('status', TaskStatus::Done)
                ->whereDate('completed_at', $date->toDateString())
                ->exists();

            if (! $hasCompletedTask && ! $date->isToday()) {
                break;
            }

            if ($hasCompletedTask) {
                $streak++;
            }

            $date->subDay();
        }

        return $streak;
    }
}
