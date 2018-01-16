<?php

namespace App\Policies;

use App\Motorcycle;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MotorcyclePolicy
{
    use HandlesAuthorization;


    public function update(User $user, Motorcycle $motorcycle)
    {
        return $user->id === $motorcycle->user_id;
    }

    public function destroy(User $user, Motorcycle $motorcycle)
    {
        return $user->id === $motorcycle->user_id;
    }
}
