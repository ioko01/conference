<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class MailController extends Controller
{
    public function verify(){
        return view('auth.verify-email');
    }

    public function verify_id(EmailVerificationRequest $request){
        $request->fulfill();

        return redirect('/');
    }

    public function verify_notification(Request $request){
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}