<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\LinkOral;
use Illuminate\Http\Request;

class LinkOralController extends Controller
{
    public function index()
    {
        $conference = Conference::where('status', 1)->first();
        $link_orals = LinkOral::leftjoin('conferences', 'conferences.id', 'link_orals.conference_id')
            ->where('conferences.status', 1)
            ->get();

        return view('frontend.pages.oral_link', compact('conference', 'link_orals'));
    }
}
