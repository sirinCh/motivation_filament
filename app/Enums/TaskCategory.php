<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskCategory: string
{
    case Design = 'design';
    case Dev = 'dev';
    case Marketing = 'marketing';
    case Personal = 'personal';

    public function getLabel(): string
    {
        return match ($this) {
            self::Design => 'Design',
            self::Dev => 'Dev',
            self::Marketing => 'Marketing',
            self::Personal => 'Personnel',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Design => 'primary',
            self::Dev => 'info',
            self::Marketing => 'danger',
            self::Personal => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Design => 'heroicon-o-paint-brush',
            self::Dev => 'heroicon-o-code-bracket',
            self::Marketing => 'heroicon-o-chart-bar',
            self::Personal => 'heroicon-o-home',
        };
    }
}
