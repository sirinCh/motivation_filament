<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Enums\TaskCategory;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Filament\Admin\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Productivité';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->maxLength(65535),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('priority')
                                    ->label('Priorité')
                                    ->options(TaskPriority::class)
                                    ->default(TaskPriority::Medium)
                                    ->required(),

                                Forms\Components\Select::make('category')
                                    ->label('Catégorie')
                                    ->options(TaskCategory::class)
                                    ->default(TaskCategory::Personal)
                                    ->required(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Statut')
                                    ->options(TaskStatus::class)
                                    ->default(TaskStatus::Todo)
                                    ->required(),

                                Forms\Components\DatePicker::make('deadline')
                                    ->label('Deadline')
                                    ->native(false),
                            ]),

                        Forms\Components\TextInput::make('estimated_time')
                            ->label('Estimation (minutes)')
                            ->numeric()
                            ->default(30)
                            ->minValue(1)
                            ->maxValue(1440)
                            ->suffix('min'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->weight('font-bold'),

                Tables\Columns\TextColumn::make('priority')
                    ->label('Priorité')
                    ->badge()
                    ->icon(fn (Task $record): string => $record->priority->getIcon())
                    ->color(fn (Task $record): string => $record->priority->getColor()),

                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->icon(fn (Task $record): string => $record->category->getIcon())
                    ->color(fn (Task $record): string => $record->category->getColor()),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->icon(fn (Task $record): string => $record->status->getIcon())
                    ->color(fn (Task $record): string => $record->status->getColor()),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn (Task $record): string => $record->deadline?->isPast() && $record->status !== TaskStatus::Done ? 'danger' : 'gray'),

                Tables\Columns\TextColumn::make('estimated_time')
                    ->label('Temps')
                    ->suffix(' min')
                    ->sortable(),

                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Terminé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('priority')
                    ->options(TaskPriority::class)
                    ->label('Priorité'),

                Tables\Filters\SelectFilter::make('category')
                    ->options(TaskCategory::class)
                    ->label('Catégorie'),

                Tables\Filters\SelectFilter::make('status')
                    ->options(TaskStatus::class)
                    ->label('Statut'),

                Tables\Filters\Filter::make('deadline')
                    ->form([
                        Forms\Components\DatePicker::make('deadline_from')->label('Deadline du'),
                        Forms\Components\DatePicker::make('deadline_to')->label('Deadline au'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['deadline_from'], fn (Builder $query, $date) => $query->whereDate('deadline', '>=', $date))
                            ->when($data['deadline_to'], fn (Builder $query, $date) => $query->whereDate('deadline', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
