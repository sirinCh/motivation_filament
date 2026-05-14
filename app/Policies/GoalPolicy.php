<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Goal;
use App\Models\User;

class GoalPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id || $user->is_admin;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id || $user->is_admin;
    }

    public function delete(User $user, Goal $goal): bool
    {
        return $user->id === $goal->user_id || $user->is_admin;
    }
}
