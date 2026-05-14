<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\QuoteResource\Pages;

use App\Filament\Admin\Resources\QuoteResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateQuote extends CreateRecord
{
    protected static string $resource = QuoteResource::class;
}
