<?php

namespace App\Policies;

use App\Models\Establishment;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobOfferPolicy
{
    public function act(User $user, JobOffer $job): bool
    {
        return $user->organizations->contains($job->establishment->organization_id);
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
    public function view(User $user, JobOffer $job): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Establishment $establishment): bool
    {
        return $user->organizations->contains($establishment->organization_id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, JobOffer $job): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, JobOffer $job): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, JobOffer $job): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, JobOffer $job): bool
    {
        return false;
    }
}
