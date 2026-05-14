<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\PomodoroSession;
use App\Models\User;

class PomodoroSessionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PomodoroSession $session): bool
    {
        return $user->id === $session->user_id || $user->is_admin;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, PomodoroSession $session): bool
    {
        return $user->id === $session->user_id || $user->is_admin;
    }

    public function delete(User $user, PomodoroSession $session): bool
    {
        return $user->id === $session->user_id || $user->is_admin;
    }
}
