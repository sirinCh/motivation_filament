<?php

declare(strict_types=1);

namespace App\Enums;

enum MediaCategory: string
{
    case Mindset = 'mindset';
    case Sport = 'sport';
    case Business = 'business';
    case BienEtre = 'bien_etre';

    public function getLabel(): string
    {
        return match ($this) {
            self::Mindset => 'Mindset',
            self::Sport => 'Sport',
            self::Business => 'Business',
            self::BienEtre => 'Bien-être',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Mindset => 'primary',
            self::Sport => 'danger',
            self::Business => 'info',
            self::BienEtre => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Mindset => 'heroicon-o-light-bulb',
            self::Sport => 'heroicon-o-trophy',
            self::Business => 'heroicon-o-briefcase',
            self::BienEtre => 'heroicon-o-heart',
        };
    }
}
