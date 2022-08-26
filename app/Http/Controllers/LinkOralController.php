<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Faculty;
use App\Models\LinkOral;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LinkOralController extends Controller
{
    public function index()
    {
        $conference = Conference::where('status', 1)->first();
        $faculties = Faculty::get();
        $tips = Tip::where('group', '1')->get();
        $link_orals = LinkOral::select(
            'link_orals.id as id',
            'link_orals.room as room',
            'link_orals.link as link',
            'link_orals.path as path',
            'faculties.name as name',
            'conferences.status_present_oral as status_present_oral'
        )
            ->leftjoin('faculties', 'faculties.id', 'link_orals.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'link_orals.conference_id')
            ->where('conferences.status', 1)
            ->get();

        foreach ($link_orals as $link_oral) {
            $link_oral->path = Storage::url($link_oral->path);
        }

        $colors = ["primary", "info", "warning", "success", "danger"];
        return view('frontend.pages.oral_link', compact('conference', 'link_orals', 'faculties', 'colors', 'tips'));
    }
}
