<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('backend.pages.user', compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);
        $positions = Position::get();
        $kotas = Kota::get();
        return view('backend.pages.show_user', compact('user', 'positions', 'kotas'));
    }

    public function update(Request $request, $id)
    {
    }
}
