<?php

declare(strict_types=1);

namespace App\Enums;

enum PomodoroSessionType: string
{
    case Focus = 'focus';
    case ShortBreak = 'short_break';
    case LongBreak = 'long_break';

    public function getLabel(): string
    {
        return match ($this) {
            self::Focus => 'Focus',
            self::ShortBreak => 'Pause courte',
            self::LongBreak => 'Pause longue',
        };
    }

    public function getDuration(): int
    {
        return match ($this) {
            self::Focus => 25,
            self::ShortBreak => 5,
            self::LongBreak => 15,
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Focus => 'danger',
            self::ShortBreak => 'success',
            self::LongBreak => 'info',
        };
    }
}
