<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PomodoroSessionResource\Pages;

use App\Filament\Admin\Resources\PomodoroSessionResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePomodoroSession extends CreateRecord
{
    protected static string $resource = PomodoroSessionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
