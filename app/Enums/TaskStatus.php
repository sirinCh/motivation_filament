<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskStatus: string
{
    case Todo = 'todo';
    case Progress = 'progress';
    case Done = 'done';

    public function getLabel(): string
    {
        return match ($this) {
            self::Todo => 'À faire',
            self::Progress => 'En cours',
            self::Done => 'Terminé',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Todo => 'gray',
            self::Progress => 'warning',
            self::Done => 'success',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Todo => 'heroicon-o-clipboard',
            self::Progress => 'heroicon-o-arrow-path',
            self::Done => 'heroicon-o-check-circle',
        };
    }
}
