<?php

namespace App\Policies;

use App\Models\SendEditWordTwo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SendEditWordTwoPolicy
{
    use HandlesAuthorization;

    public function update(User $user, SendEditWordTwo $send_edit_word_two)
    {
        return $user->id == $send_edit_word_two->user_id;
    }
}
