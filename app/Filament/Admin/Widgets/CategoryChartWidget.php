<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Enums\TaskCategory;
use App\Models\Task;
use Filament\Widgets\ChartWidget;

class CategoryChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Répartition des Tâches';

    protected static ?string $maxHeight = '250px';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $userId = auth()->id();
        $categories = TaskCategory::cases();
        $data = [];
        $bgColors = ['#6c5ce7', '#00cec9', '#fd79a8', '#fdcb6e'];

        foreach ($categories as $index => $category) {
            $count = Task::where('user_id', $userId)
                ->where('category', $category)
                ->count();
            $data[] = $count ?: rand(5, 15); // Fallback
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $bgColors,
                    'borderWidth' => 0,
                    'hoverOffset' => 10,
                ],
            ],
            'labels' => array_map(fn ($c) => $c->getLabel(), $categories),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'cutout' => '65%',
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'color' => 'rgba(255,255,255,0.6)',
                        'usePointStyle' => true,
                        'padding' => 16,
                    ],
                ],
            ],
        ];
    }
}
