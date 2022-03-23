<?php

namespace App\Policies;

use App\Models\SendEditPdfTwo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SendEditPdfTwoPolicy
{
    use HandlesAuthorization;

    public function update(User $user, SendEditPdfTwo $send_edit_pdf_two)
    {
        return $user->id == $send_edit_pdf_two->user_id;
    }
}
