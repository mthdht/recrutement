<?php

namespace App\Policies;

use App\Models\Establishment;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EstablishmentPolicy
{

    public function act(User $user, Establishment $establishment): bool
    {
        return $user->organizations->contains($establishment->organization);
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Establishment $establishment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Organization $organization): bool
    {
        return $user->organizations->contains($organization);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Establishment $establishment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Establishment $establishment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Establishment $establishment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Establishment $establishment): bool
    {
        return false;
    }
}
