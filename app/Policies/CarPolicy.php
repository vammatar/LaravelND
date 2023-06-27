<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return in_array($user->role, [User::ROLE_ADMIN, User::ROLE_READ_ONLY, User::ROLE_USER]);
    }

    public function view(User $user, Car $car)
    {
        if ($user->role === User::ROLE_ADMIN || $user->role === User::ROLE_READ_ONLY) {
            return true;
        }

        // for a basic user role
        return $user->id === $car->owner->user_id;
    }

    public function create(User $user)
    {
        return in_array($user->role, [User::ROLE_ADMIN, User::ROLE_USER]);
    }

    public function update(User $user, Car $car)
    {
        if ($user->role === User::ROLE_ADMIN) {
            return true;
        }

        // for a basic user or read_user role
        return $user->id === $car->owner->user_id;
    }

    public function delete(User $user, Car $car)
    {
        return $user->id === $car->owner->user_id || $user->role == User::ROLE_ADMIN;
    }

    public function restore(User $user, Car $car)
    {
        return $user->id === $car->owner->user_id || $user->role == User::ROLE_ADMIN;
    }

    public function forceDelete(User $user, Car $car)
    {
        return $user->id === $car->owner->user_id || $user->role == User::ROLE_ADMIN;
    }
}
