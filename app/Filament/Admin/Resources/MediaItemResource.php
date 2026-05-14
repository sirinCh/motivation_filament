<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Enums\MediaCategory;
use App\Enums\MediaType;
use App\Filament\Admin\Resources\MediaItemResource\Pages;
use App\Models\MediaItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class MediaItemResource extends Resource
{
    protected static ?string $model = MediaItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-play-circle';

    protected static ?string $navigationGroup = 'Inspiration';

    protected static ?int $navigationSort = 3;

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
                    ->label('Titre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(65535),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->options(MediaType::class)
                            ->default(MediaType::Video)
                            ->required(),

                        Forms\Components\Select::make('category')
                            ->label('Catégorie')
                            ->options(MediaCategory::class)
                            ->default(MediaCategory::Mindset)
                            ->required(),
                    ]),

                Forms\Components\TextInput::make('external_url')
                    ->label('URL externe (YouTube, etc.)')
                    ->url()
                    ->prefixIcon('heroicon-o-link')
                    ->maxLength(2048),

                Forms\Components\TextInput::make('author')
                    ->label('Auteur / Créateur')
                    ->maxLength(255),

                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Miniature')
                    ->image()
                    ->directory('media-thumbnails')
                    ->maxSize(2048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (MediaItem $record): string => $record->type->getColor()),

                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->color(fn (MediaItem $record): string => $record->category->getColor()),

                Tables\Columns\TextColumn::make('author')
                    ->label('Auteur')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Vues')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(MediaType::class)
                    ->label('Type'),

                Tables\Filters\SelectFilter::make('category')
                    ->options(MediaCategory::class)
                    ->label('Catégorie'),
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
            'index' => Pages\ListMediaItems::route('/'),
            'create' => Pages\CreateMediaItem::route('/create'),
            'edit' => Pages\EditMediaItem::route('/{record}/edit'),
        ];
    }
}
