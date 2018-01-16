<?php

namespace App\Policies;

use App\Motorcycle;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MotorcyclePolicy
{
    use HandlesAuthorization;


    /**
     * Check if user can update motorcycle record.
     *
     * @param User $user
     * @param Motorcycle $motorcycle
     * @return bool
     */
    public function update(User $user, Motorcycle $motorcycle)
    {
        return $user->id === $motorcycle->user_id;
    }

    /**
     * Check if user can delete motorcycle record.
     *
     * @param User $user
     * @param Motorcycle $motorcycle
     * @return bool
     */
    public function destroy(User $user, Motorcycle $motorcycle)
    {
        return $user->id === $motorcycle->user_id;
    }
}
