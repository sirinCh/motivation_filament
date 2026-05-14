<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\MediaItem;
use App\Models\User;

class MediaItemPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MediaItem $mediaItem): bool
    {
        return $user->id === $mediaItem->user_id || $user->is_admin;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, MediaItem $mediaItem): bool
    {
        return $user->id === $mediaItem->user_id || $user->is_admin;
    }

    public function delete(User $user, MediaItem $mediaItem): bool
    {
        return $user->id === $mediaItem->user_id || $user->is_admin;
    }
}
