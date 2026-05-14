<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MediaItemResource\Pages;

use App\Filament\Admin\Resources\MediaItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditMediaItem extends EditRecord
{
    protected static string $resource = MediaItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
