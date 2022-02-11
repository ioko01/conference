<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SendEditPdf;
use Illuminate\Auth\Access\HandlesAuthorization;

class SendEditPdfPolicy
{
    use HandlesAuthorization;

    public function update(User $user, SendEditPdf $send_edit_pdf){
        return $user->id == $send_edit_pdf->user_id;
    }
}
