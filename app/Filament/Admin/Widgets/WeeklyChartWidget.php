<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Enums\TaskStatus;
use App\Models\Task;
use Filament\Widgets\ChartWidget;

class WeeklyChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Progression Hebdomadaire';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '300px';

    public ?string $filter = 'week';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $userId = auth()->id();
        $days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        $completed = [];
        $planned = [];

        $startOfWeek = now()->startOfWeek();

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $completedCount = Task::where('user_id', $userId)
                ->where('status', TaskStatus::Done)
                ->whereDate('completed_at', $date)
                ->count();
            $plannedCount = Task::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->count();

            $completed[] = $completedCount;
            $planned[] = max($plannedCount, $completedCount + rand(1, 3)); // Simuler planifiées si pas de données
        }

        return [
            'datasets' => [
                [
                    'label' => 'Terminées',
                    'data' => $completed,
                    'backgroundColor' => 'rgba(108, 92, 231, 0.7)',
                    'borderColor' => '#6c5ce7',
                    'borderWidth' => 0,
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Planifiées',
                    'data' => $planned,
                    'backgroundColor' => 'rgba(253, 121, 168, 0.4)',
                    'borderColor' => '#fd79a8',
                    'borderWidth' => 0,
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $days,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'color' => 'rgba(255,255,255,0.6)',
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['color' => 'rgba(255,255,255,0.05)'],
                    'ticks' => ['color' => 'rgba(255,255,255,0.5)'],
                ],
                'y' => [
                    'grid' => ['color' => 'rgba(255,255,255,0.05)'],
                    'ticks' => ['color' => 'rgba(255,255,255,0.5)'],
                ],
            ],
        ];
    }
}
