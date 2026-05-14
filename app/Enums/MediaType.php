<?php

declare(strict_types=1);

namespace App\Enums;

enum MediaType: string
{
    case Video = 'video';
    case Podcast = 'podcast';
    case Reel = 'reel';

    public function getLabel(): string
    {
        return match ($this) {
            self::Video => 'Vidéo',
            self::Podcast => 'Podcast',
            self::Reel => 'Reel',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Video => 'primary',
            self::Podcast => 'info',
            self::Reel => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Video => 'heroicon-o-video-camera',
            self::Podcast => 'heroicon-o-microphone',
            self::Reel => 'heroicon-o-film',
        };
    }
}
