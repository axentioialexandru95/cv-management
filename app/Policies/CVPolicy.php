<?php

namespace App\Policies;

use App\Models\CV;
use App\Models\User;

class CVPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CV $cv): bool
    {
        return $cv->user_id === $user->id;
    }

    /**
     * Determine whether anyone can view the model publicly.
     */
    public function viewPublicly(?User $user, CV $cv): bool
    {
        return $cv->is_public;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CV $cv): bool
    {
        return $cv->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CV $cv): bool
    {
        return $cv->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CV $cv): bool
    {
        return $cv->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CV $cv): bool
    {
        return $cv->user_id === $user->id;
    }
}
