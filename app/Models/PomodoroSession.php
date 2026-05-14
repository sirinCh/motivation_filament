<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PomodoroSessionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PomodoroSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'duration_minutes',
        'started_at',
        'completed_at',
        'session_type',
    ];

    protected function casts(): array
    {
        return [
            'session_type' => PomodoroSessionType::class,
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
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

    public function scopeCompletedToday($query)
    {
        return $query->whereNotNull('completed_at')
            ->whereDate('completed_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }
}
