<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\QuoteResource\Pages;

use App\Filament\Admin\Resources\QuoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditQuote extends EditRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
