<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MediaItemResource\Pages;

use App\Filament\Admin\Resources\MediaItemResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateMediaItem extends CreateRecord
{
    protected static string $resource = MediaItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
