<?php

namespace App\Policies;

use App\Business;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the app business.
     *
     * @param \App\User     $user
     * @param \App\Business $business
     *
     * @return mixed
     */
    public function view(User $user, Business $business)
    {
        return true;
    }

    /**
     * Determine whether the user can create app businesses.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the app business.
     *
     * @param \App\User     $user
     * @param \App\Business $business
     *
     * @return mixed
     */
    public function update(User $user, Business $business)
    {
        return $user->id === $business->owner_id;
    }

    /**
     * Determine whether the user can delete the app business.
     *
     * @param \App\User     $user
     * @param \App\Business $business
     *
     * @return mixed
     */
    public function delete(User $user, Business $business)
    {
        return $user->id === $business->owner_id;
    }

    /**
     * Determine whether the user can restore the app business.
     *
     * @param \App\User     $user
     * @param \App\Business $business
     *
     * @return mixed
     */
    public function restore(User $user, Business $business)
    {
        return $user->id === $business->owner_id;
    }

    /**
     * Determine whether the user can permanently delete the app business.
     *
     * @param \App\User     $user
     * @param \App\Business $business
     *
     * @return mixed
     */
    public function forceDelete(User $user, Business $business)
    {
        return $user->id === $business->owner_id;
    }
}
