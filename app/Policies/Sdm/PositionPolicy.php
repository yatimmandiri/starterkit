<?php

namespace App\Policies\Sdm;

use App\Models\Core\User;
use App\Models\Sdm\Position;

class PositionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-position');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Position $Position): bool
    {
        return $user->hasPermissionTo('view-position');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-position');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Position $Position): bool
    {
        return $user->hasPermissionTo('update-position');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Position $Position): bool
    {
        return $user->hasPermissionTo('delete-position');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Position $Position): bool
    {
        return $user->hasPermissionTo('restore-position');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Position $Position): bool
    {
        return $user->hasPermissionTo('force-delete-position');
    }

    public function data(User $user): bool
    {
        return $user->hasPermissionTo('data-position');
    }
}
