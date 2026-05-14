<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskPriority: string
{
    case High = 'high';
    case Medium = 'medium';
    case Low = 'low';

    public function getLabel(): string
    {
        return match ($this) {
            self::High => 'Haute',
            self::Medium => 'Moyenne',
            self::Low => 'Basse',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::High => 'danger',
            self::Medium => 'warning',
            self::Low => 'success',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::High => 'heroicon-o-fire',
            self::Medium => 'heroicon-o-exclamation-triangle',
            self::Low => 'heroicon-o-check-circle',
        };
    }
}
