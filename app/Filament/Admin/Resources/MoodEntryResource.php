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
                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->default(now())
                    ->required()
                    ->native(false),

                Forms\Components\Slider::make('mood_score')
                    ->label('Humeur')
                    ->minValue(1)
                    ->maxValue(10)
                    ->default(7)
                    ->step(1)
                    ->required()
                    ->helperText('1 = Très mal | 10 = Excellent'),

                Forms\Components\Slider::make('energy_score')
                    ->label('Énergie')
                    ->minValue(1)
                    ->maxValue(10)
                    ->default(7)
                    ->step(1)
                    ->required()
                    ->helperText('1 = Épuisé | 10 = Très énergique'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('mood_score')
                    ->label('Humeur')
                    ->numeric()
                    ->sortable()
                    ->color(fn (MoodEntry $record): string => match (true) {
                        $record->mood_score <= 3 => 'danger',
                        $record->mood_score <= 6 => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\TextColumn::make('energy_score')
                    ->label('Énergie')
                    ->numeric()
                    ->sortable()
                    ->color(fn (MoodEntry $record): string => match (true) {
                        $record->energy_score <= 3 => 'danger',
                        $record->energy_score <= 6 => 'warning',
                        default => 'success',
                    }),
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
