<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\PomodoroSessionResource\Pages;

use App\Filament\Admin\Resources\PomodoroSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditPomodoroSession extends EditRecord
{
    protected static string $resource = PomodoroSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
