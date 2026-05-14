<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuoteResource\Pages;
use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 10;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->is_admin ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Citation')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->schema([
                        Forms\Components\Textarea::make('text')
                            ->label('Texte de la citation')
                            ->required()
                            ->rows(4)
                            ->maxLength(65535)
                            ->placeholder('Saisissez la citation ici…'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('author')
                                    ->label('Auteur')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Ex: Steve Jobs')
                                    ->prefixIcon('heroicon-o-user'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Citation active')
                                    ->default(true)
                                    ->required()
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
                Tables\Columns\TextColumn::make('text')
                    ->label('Citation')
                    ->limit(80)
                    ->searchable()
                    ->weight('font-bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('author')
                    ->label('Auteur')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-user'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créée le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Statut')
                    ->trueLabel('Actives')
                    ->falseLabel('Inactives')
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
            'index' => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'edit' => Pages\EditQuote::route('/{record}/edit'),
        ];
    }
}
