<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\Conference;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

        $attends = Attend::select('*')
            ->leftjoin('conferences', 'attends.conference_id', 'conferences.id')
            ->where('conferences.status', 1)
            ->get();

        $data = [];
        foreach ($users as $user) {
            array_push($data, $user);
        }
        foreach ($attends as $attend) {
            array_push($data, $attend);
        }
        $i = 1;
        DB::disconnect('conferences');
        DB::disconnect('users');
        DB::disconnect('attends');
        return view('frontend.pages.list_attend', compact('data', 'conference', 'i'));
    }
}
