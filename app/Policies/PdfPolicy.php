<?php

namespace App\Policies;

use App\Models\Pdf;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PdfPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pdf  $pdf
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Pdf $pdf)
    {
        return $pdf->user_id == $user->id;
    }
}