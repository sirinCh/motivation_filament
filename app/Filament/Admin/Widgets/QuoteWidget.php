<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Models\Quote;
use Filament\Widgets\Widget;

class QuoteWidget extends Widget
{
    protected static string $view = 'filament.admin.widgets.quote-widget';

    protected int|string|array $columnSpan = 'full';

    public function getQuote(): ?Quote
    {
        return Quote::active()->inRandomOrder()->first();
    }
}
