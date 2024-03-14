<?php

namespace App\Policies;

use App\Models\Rute;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RutePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->can('rute'))
        return true;
    else
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Rute $rute): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Rute $rute): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Rute $rute): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Rute $rute): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Rute $rute): bool
    {
        //
    }
}
