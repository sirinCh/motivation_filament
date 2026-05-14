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
                Forms\Components\Section::make('Objectif')
                    ->icon('heroicon-o-trophy')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Objectif')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ex: Lire 12 livres cette année'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('target_value')
                                    ->label('Objectif cible')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->suffix('unités'),

                                Forms\Components\TextInput::make('current_value')
                                    ->label('Valeur actuelle')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required()
                                    ->suffix('unités'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('deadline')
                                    ->label('Date butoir')
                                    ->native(false)
                                    ->prefixIcon('heroicon-o-calendar'),

                                Forms\Components\Toggle::make('is_completed')
                                    ->label('Objectif atteint')
                                    ->default(false)
                                    ->onIcon('heroicon-m-check-circle')
                                    ->offIcon('heroicon-m-x-circle')
                                    ->onColor('success'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Objectif')
                    ->searchable()
                    ->sortable()
                    ->weight('font-bold'),

                Tables\Columns\TextColumn::make('progress')
                    ->label('Progrès')
                    ->state(fn (Goal $record): string => "{$record->current_value} / {$record->target_value}")
                    ->badge()
                    ->color(fn (Goal $record): string => $record->is_completed ? 'success' : 'warning'),

                Tables\Columns\TextColumn::make('progress_percentage')
                    ->label('Avancement')
                    ->state(fn (Goal $record): string => $record->progressPercentage.'%')
                    ->badge()
                    ->color(fn (Goal $record): string => match (true) {
                        $record->progressPercentage >= 100 => 'success',
                        $record->progressPercentage >= 50 => 'warning',
                        default => 'danger',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_completed')
                    ->label('Terminé')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->date('d/m/Y')
                    ->sortable()
                    ->placeholder('—')
                    ->color(fn (Goal $record): string => $record->deadline?->isPast() && ! $record->is_completed ? 'danger' : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_completed')
                    ->label('Statut')
                    ->trueLabel('Atteints')
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
            ])
            ->defaultSort('created_at', 'desc');
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
