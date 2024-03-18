<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Faculty;
use App\Models\PresentPoster;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PosterScheduleController extends Controller
{
    public function index()
    {
        $conference = Conference::where('status', 1)->first();
        $tips = Tip::where('group', '1')->get();
        $present_posters = PresentPoster::select(
            'present_posters.id as id',
            'present_posters.topic_th as topic_th',
            'present_posters.present_poster_id as present_poster_id',
            'present_posters.time_start as time_start',
            'present_posters.time_end as time_end',
            'faculties.name as name',
            'conferences.status_present_poster as status_present_poster'
        )
            ->leftjoin('faculties', 'faculties.id', 'present_posters.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'present_posters.conference_id')
            ->where('conferences.status', 1)
            ->orderBy(DB::raw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(present_poster_id , "0", ""),"1",""),"2",""),"3",""),"4",""),"5",""),"6",""),"7",""),"8",""),"9",""), LENGTH(present_poster_id)'))
            ->get();

        $faculties = Faculty::get();

        $colors = ['', 'darkblue', 'purple', 'yellow', 'orange', 'green'];
        $textColors = ['', 'white', 'white', 'dark', 'white', 'white'];

        DB::disconnect('conferences');
        DB::disconnect('tips');
        DB::disconnect('present_posters');
        DB::disconnect('faculties');
        return view('frontend.pages.poster_schedule', compact('present_posters', 'conference', 'faculties', 'colors', 'tips', 'textColors'));
    }
}
