<?php

namespace App\Policies;

use App\Models\SendEditStatementTwo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SendEditStatementTwoPolicy
{
    use HandlesAuthorization;

    public function update(User $user, SendEditStatementTwo $send_edit_stm_two)
    {
        return $user->id == $send_edit_stm_two->user_id;
    }
}
