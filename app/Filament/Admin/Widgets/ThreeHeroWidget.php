<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class ThreeHeroWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.three-hero-widget';

    protected int|string|array $columnSpan = 'full';
}
