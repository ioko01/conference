<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Faculty;
use App\Models\LinkPoster;
use App\Models\Tip;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LinkPosterController extends Controller
{
    public function index()
    {
        $conference = Conference::where('status', 1)->first();
        $faculties = Faculty::get();
        $tips = Tip::where('group', '1')->get();
        $link_posters = LinkPoster::select(
            'link_posters.id as id',
            'link_posters.room as room',
            'link_posters.link as link',
            'link_posters.path as path',
            'faculties.name as name',
            'conferences.status_present_oral as status_present_oral'
        )
            ->leftjoin('faculties', 'faculties.id', 'link_posters.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'link_posters.conference_id')
            ->where('conferences.status', 1)
            ->get();

        foreach ($link_posters as $link_poster) {
            $link_poster->path = Storage::url($link_poster->path);
        }

        $colors = ['', 'darkblue', 'purple', 'yellow', 'orange', 'green'];
        $textColors = ['', 'white', 'white', 'dark', 'white', 'white'];

        DB::disconnect('conferences');
        DB::disconnect('faculties');
        DB::disconnect('tips');
        DB::disconnect('link_posters');
        return view('frontend.pages.poster_link', compact('conference', 'link_posters', 'faculties', 'colors', 'tips', 'textColors'));
    }
}
