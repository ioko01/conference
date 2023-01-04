<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $positions = Position::get();
        $kotas = Kota::get();

        DB::disconnect('users');
        DB::disconnect('positions');
        DB::disconnect('kotas');

        return view('frontend.pages.account', compact('user', 'positions', 'kotas'));
    }
}
