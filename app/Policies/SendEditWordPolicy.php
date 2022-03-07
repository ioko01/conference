<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SendEditWord;
use Illuminate\Auth\Access\HandlesAuthorization;

class SendEditWordPolicy
{
    use HandlesAuthorization;

    public function update(User $user, SendEditWord $send_edit_word)
    {
        return $user->id == $send_edit_word->user_id;
    }
}
