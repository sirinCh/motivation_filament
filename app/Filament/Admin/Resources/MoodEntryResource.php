<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MoodEntryResource\Pages;
use App\Models\MoodEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class MoodEntryResource extends Resource
{
    protected static ?string $model = MoodEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Productivité';

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Suivi de l\'humeur')
                    ->icon('heroicon-o-heart')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Date')
                            ->default(now())
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-calendar'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('mood_score')
                                    ->label('Humeur')
                                    ->options([
                                        1 => '😞 1 — Très mal',
                                        2 => '😟 2 — Mal',
                                        3 => '😕 3 — Pas super',
                                        4 => '😐 4 — Bof',
                                        5 => '🙂 5 — Correct',
                                        6 => '😊 6 — Bien',
                                        7 => '😀 7 — Très bien',
                                        8 => '😁 8 — Super',
                                        9 => '🤩 9 — Excellent',
                                        10 => '🌟 10 — Parfait',
                                    ])
                                    ->required()
                                    ->helperText('1 = Très mal | 10 = Excellent')
                                    ->prefixIcon('heroicon-o-face-smile'),

                                Forms\Components\Select::make('energy_score')
                                    ->label('Énergie')
                                    ->options([
                                        1 => '🔋 1 — Épuisé',
                                        2 => '🔋 2 — Très faible',
                                        3 => '🔋 3 — Faible',
                                        4 => '🔋 4 — Peu d\'énergie',
                                        5 => '⚡ 5 — Normal',
                                        6 => '⚡ 6 — Assez bien',
                                        7 => '⚡ 7 — Bien',
                                        8 => '⚡ 8 — Très bien',
                                        9 => '🚀 9 — Plein d\'énergie',
                                        10 => '🚀 10 — Au max',
                                    ])
                                    ->required()
                                    ->helperText('1 = Épuisé | 10 = Très énergique')
                                    ->prefixIcon('heroicon-o-bolt'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->weight('font-bold'),

                Tables\Columns\TextColumn::make('mood_score')
                    ->label('Humeur')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (int $state): string => "😊 {$state}/10")
                    ->color(fn (MoodEntry $record): string => match (true) {
                        $record->mood_score <= 3 => 'danger',
                        $record->mood_score <= 6 => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\TextColumn::make('energy_score')
                    ->label('Énergie')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (int $state): string => "⚡ {$state}/10")
                    ->color(fn (MoodEntry $record): string => match (true) {
                        $record->energy_score <= 3 => 'danger',
                        $record->energy_score <= 6 => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enregistré le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->label('Du')
                            ->native(false),
                        Forms\Components\DatePicker::make('date_to')
                            ->label('Au')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['date_from'], fn (Builder $q, $date) => $q->whereDate('date', '>=', $date))
                            ->when($data['date_to'], fn (Builder $q, $date) => $q->whereDate('date', '<=', $date));
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
            ->defaultSort('date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMoodEntries::route('/'),
            'create' => Pages\CreateMoodEntry::route('/create'),
            'edit' => Pages\EditMoodEntry::route('/{record}/edit'),
        ];
    }
}
