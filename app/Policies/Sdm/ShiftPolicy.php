<?php

namespace App\Policies\Sdm;

use App\Models\Core\User;
use App\Models\Sdm\Shift;

class ShiftPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-shift');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Shift $shift): bool
    {
        return $user->hasPermissionTo('view-shift');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-shift');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shift $shift): bool
    {
        return $user->hasPermissionTo('update-shift');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shift $shift): bool
    {
        return $user->hasPermissionTo('delete-shift');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Shift $shift): bool
    {
        return $user->hasPermissionTo('restore-shift');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Shift $shift): bool
    {
        return $user->hasPermissionTo('force-delete-shift');
    }

    public function data(User $user): bool
    {
        return $user->hasPermissionTo('data-shift');
    }
}
