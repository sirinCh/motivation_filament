<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

final class KanbanBoardPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    protected static ?string $navigationGroup = 'Productivité';

    protected static ?int $navigationSort = 6;

    protected static string $view = 'filament.admin.pages.kanban-board';

    public function getTitle(): string
    {
        return 'Tableau Kanban';
    }

    public function getTasksByStatus(TaskStatus $status): Collection
    {
        return Task::query()
            ->where('user_id', auth()->id())
            ->where('status', $status)
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function moveTask(int $taskId, string $newStatus): void
    {
        $task = Task::query()
            ->where('user_id', auth()->id())
            ->findOrFail($taskId);

        $status = TaskStatus::tryFrom($newStatus);
        if (! $status) {
            return;
        }

        $task->status = $status;
        if ($status === TaskStatus::Done) {
            $task->completed_at = now();
        } else {
            $task->completed_at = null;
        }
        $task->save();

        $this->dispatch('task-moved', taskId: $taskId, status: $newStatus);

        if ($status === TaskStatus::Done) {
            $this->dispatch('confetti');
        }
    }

    public function getPriorityColor(string $priority): string
    {
        $enum = TaskPriority::tryFrom($priority);
        return $enum?->getColor() ?? 'gray';
    }

    public function getStatusLabel(string $status): string
    {
        $enum = TaskStatus::tryFrom($status);
        return $enum?->getLabel() ?? $status;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Nouvelle Tâche')
                ->icon('heroicon-o-plus')
                ->url(fn () => \App\Filament\Admin\Resources\TaskResource::getUrl('create')),
        ];
    }
}
