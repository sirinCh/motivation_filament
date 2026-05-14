<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\MoodEntry;
use Filament\Widgets\ChartWidget;

class MoodChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Humeur & Énergie';

    protected static ?string $maxHeight = '250px';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $userId = auth()->id();
        $entries = MoodEntry::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get()
            ->reverse();

        $labels = [];
        $mood = [];
        $energy = [];

        foreach ($entries as $entry) {
            $labels[] = $entry->date->format('D');
            $mood[] = $entry->mood_score;
            $energy[] = $entry->energy_score;
        }

        // Fallback si pas assez de données
        while (count($labels) < 7) {
            array_unshift($labels, '-');
            array_unshift($mood, rand(5, 9));
            array_unshift($energy, rand(5, 9));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Humeur',
                    'data' => $mood,
                    'borderColor' => '#00cec9',
                    'backgroundColor' => 'rgba(0, 206, 201, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#00cec9',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 5,
                ],
                [
                    'label' => 'Énergie',
                    'data' => $energy,
                    'borderColor' => '#fd79a8',
                    'backgroundColor' => 'rgba(253, 121, 168, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointBackgroundColor' => '#fd79a8',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 5,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'labels' => ['color' => 'rgba(255,255,255,0.6)', 'usePointStyle' => true],
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['color' => 'rgba(255,255,255,0.05)'],
                    'ticks' => ['color' => 'rgba(255,255,255,0.5)'],
                ],
                'y' => [
                    'min' => 1,
                    'max' => 10,
                    'grid' => ['color' => 'rgba(255,255,255,0.05)'],
                    'ticks' => ['color' => 'rgba(255,255,255,0.5)', 'stepSize' => 1],
                ],
            ],
        ];
    }
}
