<?php

namespace App\Policies;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OwnerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Owner $owner)
    {
        if ($user->role === User::ROLE_ADMIN || $user->role === User::ROLE_READ_ONLY) {
            return true;
        }

        // for a basic user role
        return $user->id === $owner->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Owner $owner)
    {
        if ($user->role === User::ROLE_ADMIN) {
            return true;
        }

        // for a basic user or read_user role
        return $user->id === $owner->user_id;
    }

    public function delete(User $user, Owner $owner)
    {
        if ($user->role === User::ROLE_ADMIN) {
            return true;
        }

        // for a basic user
        return $user->id === $owner->user_id;
    }
}
