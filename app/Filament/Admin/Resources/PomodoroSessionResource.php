<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Enums\PomodoroSessionType;
use App\Filament\Admin\Resources\PomodoroSessionResource\Pages;
use App\Models\PomodoroSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class PomodoroSessionResource extends Resource
{
    protected static ?string $model = PomodoroSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Productivité';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('session_type')
                    ->label('Type de session')
                    ->options(PomodoroSessionType::class)
                    ->default(PomodoroSessionType::Focus)
                    ->required(),

                Forms\Components\TextInput::make('duration_minutes')
                    ->label('Durée (minutes)')
                    ->numeric()
                    ->default(25)
                    ->required()
                    ->minValue(1)
                    ->maxValue(300)
                    ->suffix('min'),

                Forms\Components\DateTimePicker::make('started_at')
                    ->label('Début')
                    ->default(now())
                    ->required(),

                Forms\Components\DateTimePicker::make('completed_at')
                    ->label('Terminé à')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('session_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (PomodoroSession $record): string => $record->session_type->getColor()),

                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Durée')
                    ->suffix(' min'),

                Tables\Columns\TextColumn::make('started_at')
                    ->label('Début')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Terminé')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('En cours...'),
            ])
            ->defaultSort('started_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPomodoroSessions::route('/'),
            'create' => Pages\CreatePomodoroSession::route('/create'),
            'edit' => Pages\EditPomodoroSession::route('/{record}/edit'),
        ];
    }
}
