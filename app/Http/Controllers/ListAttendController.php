<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Http\Request;

class ListAttendController extends Controller
{
    public function index()
    {
        $conference = Conference::where('status', 1)->first();
        $users = User::select('*')
            ->leftjoin('conferences', 'users.conference_id', 'conferences.id')
            ->where('conferences.status', 1)
            ->where('is_admin', 0)
            ->get();

        return view('frontend.pages.list_attend', compact('users', 'conference'));
    }
}