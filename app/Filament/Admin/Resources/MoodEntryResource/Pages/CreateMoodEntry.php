<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MoodEntryResource\Pages;

use App\Filament\Admin\Resources\MoodEntryResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateMoodEntry extends CreateRecord
{
    protected static string $resource = MoodEntryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
