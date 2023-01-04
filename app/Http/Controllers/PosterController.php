<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\PresentPoster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PosterController extends Controller
{
    public function index()
    {
        $conference = Conference::where('status', 1)->first();
        $present_posters = PresentPoster::select(
            'present_posters.id as id',
            'present_posters.topic_th as topic_th',
            'present_posters.present_poster_id as present_poster_id',
            'present_posters.link as link',
            'present_posters.path as path',
            'faculties.name as name',
            'conferences.status_present_poster as status_present_poster'
        )
            ->leftjoin('faculties', 'faculties.id', 'present_posters.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'present_posters.conference_id')
            ->where('conferences.status', 1)
            ->get();
        foreach ($present_posters as $present_poster) {
            $present_poster->path = Storage::url($present_poster->path);
        }

        DB::disconnect('conferences');
        DB::disconnect('present_posters');
        return view('frontend.pages.poster', compact('present_posters', 'conference'));
    }
}
