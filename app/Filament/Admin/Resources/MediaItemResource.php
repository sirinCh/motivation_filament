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
                Forms\Components\Section::make('Informations')
                    ->icon('heroicon-o-play-circle')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Titre du contenu'),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->maxLength(65535)
                            ->placeholder('Décrivez brièvement ce contenu…'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label('Type')
                                    ->options(MediaType::class)
                                    ->default(MediaType::Video)
                                    ->required()
                                    ->prefixIcon('heroicon-o-tag'),

                                Forms\Components\Select::make('category')
                                    ->label('Catégorie')
                                    ->options(MediaCategory::class)
                                    ->default(MediaCategory::Mindset)
                                    ->required()
                                    ->prefixIcon('heroicon-o-folder'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('external_url')
                                    ->label('URL externe (YouTube, etc.)')
                                    ->url()
                                    ->prefixIcon('heroicon-o-link')
                                    ->maxLength(2048)
                                    ->placeholder('https://…'),

                                Forms\Components\TextInput::make('author')
                                    ->label('Auteur / Créateur')
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-user')
                                    ->placeholder('Ex: Tony Robbins'),
                            ]),
                    ]),

                Forms\Components\Section::make('Médias')
                    ->icon('heroicon-o-photo')
                    ->collapsed()
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Miniature')
                            ->image()
                            ->directory('media-thumbnails')
                            ->maxSize(2048)
                            ->imagePreviewHeight('150')
                            ->helperText('Format JPG, PNG ou WebP. Max 2 Mo.'),
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

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->icon(fn (MediaItem $record): string => $record->type->getIcon())
                    ->color(fn (MediaItem $record): string => $record->type->getColor()),

                Tables\Columns\TextColumn::make('category')
                    ->label('Catégorie')
                    ->badge()
                    ->icon(fn (MediaItem $record): string => $record->category->getIcon())
                    ->color(fn (MediaItem $record): string => $record->category->getColor()),

                Tables\Columns\TextColumn::make('author')
                    ->label('Auteur')
                    ->searchable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Vues')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ajouté le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ])
            ->defaultSort('created_at', 'desc');
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
