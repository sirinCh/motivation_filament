<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GoalResource\Pages;
use App\Models\Goal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class GoalResource extends Resource
{
    protected static ?string $model = Goal::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Productivité';

    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Objectif')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('target_value')
                            ->label('Objectif cible')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),

                        Forms\Components\TextInput::make('current_value')
                            ->label('Valeur actuelle')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required(),
                    ]),

                Forms\Components\DatePicker::make('deadline')
                    ->label('Date butoir')
                    ->native(false),

                Forms\Components\Toggle::make('is_completed')
                    ->label('Terminé')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Objectif')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('progress')
                    ->label('Progrès')
                    ->state(fn (Goal $record): string => "{$record->current_value}/{$record->target_value}")
                    ->color(fn (Goal $record): string => $record->is_completed ? 'success' : 'warning'),

                Tables\Columns\TextColumn::make('progress_percentage')
                    ->label('%')
                    ->state(fn (Goal $record): int => $record->progressPercentage)
                    ->suffix('%')
                    ->color(fn (Goal $record): string => match (true) {
                        $record->progressPercentage >= 100 => 'success',
                        $record->progressPercentage >= 50 => 'warning',
                        default => 'danger',
                    }),

                Tables\Columns\IconColumn::make('is_completed')
                    ->label('Terminé')
                    ->boolean(),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->date('d/m/Y')
                    ->placeholder('—'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_completed')
                    ->label('Statut')
                    ->trueLabel('Terminés')
                    ->falseLabel('En cours')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGoals::route('/'),
            'create' => Pages\CreateGoal::route('/create'),
            'edit' => Pages\EditGoal::route('/{record}/edit'),
        ];
    }
}
