<?php

namespace App\Policies;

use App\Models\SendEditStatement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SendEditStatementPolicy
{
    use HandlesAuthorization;

    public function update(User $user, SendEditStatement $send_edit_stm)
    {
        return $user->id == $send_edit_stm->user_id;
    }
}
