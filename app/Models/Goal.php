<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'target_value',
        'current_value',
        'is_completed',
        'deadline',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'deadline' => 'date',
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

    public function getProgressPercentageAttribute(): int
    {
        if ($this->target_value === 0) {
            return 0;
        }

        return min(100, (int) round(($this->current_value / $this->target_value) * 100));
    }

    public function checkCompletion(): void
    {
        if ($this->current_value >= $this->target_value && ! $this->is_completed) {
            $this->update(['is_completed' => true]);
        }
    }
}
