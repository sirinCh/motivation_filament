<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Task;
use Filament\Widgets\Widget;

class CalendarWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.calendar-widget';

    protected int|string|array $columnSpan = ['lg' => 2];

    public function getCalendarData(): array
    {
        $userId = auth()->id();
        $now = now();
        $year = $now->year;
        $month = $now->month;

        $daysInMonth = $now->daysInMonth;
        $firstDayOfMonth = $now->copy()->firstOfMonth();
        $startDayOfWeek = ($firstDayOfMonth->dayOfWeek + 6) % 7; // Lundi = 0

        $taskDates = Task::where('user_id', $userId)
            ->whereNotNull('deadline')
            ->whereMonth('deadline', $month)
            ->whereYear('deadline', $year)
            ->pluck('deadline')
            ->map(fn ($d) => (int) $d->format('j'))
            ->toArray();

        return [
            'month_name' => $now->translatedFormat('F Y'),
            'days_in_month' => $daysInMonth,
            'start_offset' => $startDayOfWeek,
            'task_dates' => $taskDates,
            'today' => (int) $now->format('j'),
        ];
    }
}
