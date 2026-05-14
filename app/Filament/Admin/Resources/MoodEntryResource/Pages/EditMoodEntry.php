<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\MoodEntryResource\Pages;

use App\Filament\Admin\Resources\MoodEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditMoodEntry extends EditRecord
{
    protected static string $resource = MoodEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
