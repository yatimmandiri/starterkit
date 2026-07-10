<?php

namespace App\Policies\Sdm;

use App\Models\Core\User;
use App\Models\Sdm\Holiday;

class HolidayPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-holiday');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Holiday $holiday): bool
    {
        return $user->hasPermissionTo('view-holiday');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-holiday');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Holiday $holiday): bool
    {
        return $user->hasPermissionTo('update-holiday');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Holiday $holiday): bool
    {
        return $user->hasPermissionTo('delete-holiday');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Holiday $holiday): bool
    {
        return $user->hasPermissionTo('restore-holiday');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Holiday $holiday): bool
    {
        return $user->hasPermissionTo('force-delete-holiday');
    }

    public function data(User $user): bool
    {
        return $user->hasPermissionTo('data-holiday');
    }
}
