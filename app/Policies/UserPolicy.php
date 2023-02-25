<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Department;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\App;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }



    public function update(User $user)
    {
        return $user->level > 3;
    }

    public function personnel(User $user)
    {
        return $user->department_id == 3 ||  $user->level == 2 || $user->position_id == 1 || $user->position_id == 2 || $user->position_id == 3 || $user->position_id == 4 || $user->position_id == 5 || $user->position_id == 6 || $user->position_id == 7 || $user->position_id == 8;
    }
}

