<?php

namespace App\Policies;

use App\Models\Slip;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlipPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
     public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Slip  $slip
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Slip $slip)
    {
        return $slip->user_id == $user->id;
    }

}
