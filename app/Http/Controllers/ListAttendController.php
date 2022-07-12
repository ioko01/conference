<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ListAttendController extends Controller
{
    public function index()
    {
        $users = User::select('*')
            ->leftjoin('conferences', 'users.conference_id', 'conferences.id')
            ->where('conferences.status', 1)
            ->get();

        return view('frontend.pages.list_attend', compact('users'));
    }
}
