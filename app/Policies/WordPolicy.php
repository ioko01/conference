<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Word;
use Illuminate\Auth\Access\HandlesAuthorization;

class WordPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Word $word)
    {
        return $word->user_id == $user->id;
    }

}
