<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Position;
use App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $positions = Position::get();
        $kotas = Kota::get();

        return view('frontend.pages.account', compact('user', 'positions', 'kotas'));
    }
}
