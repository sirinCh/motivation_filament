<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MediaCategory;
use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MediaItem extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'category',
        'external_url',
        'thumbnail',
        'author',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'type' => MediaType::class,
            'category' => MediaCategory::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('media_file')
            ->acceptsMimeTypes(['video/mp4', 'audio/mpeg', 'audio/mp3']);
    }
}
