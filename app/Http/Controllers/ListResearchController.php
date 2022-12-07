<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Research;

class ListResearchController extends Controller
{
    public function index()
    {
        $conference = Conference::where('status', 1)->first();
        $researchs = Research::select(
            'researchs.topic_id as topic_id',
            'researchs.topic_th as topic_th',
            'researchs.presenter as presenter',
            'presents.name as present_name',
            'faculties.name as faculty_name',
            'status_researchs.name as topic_status',
            'researchs.topic_status as topic_status_id',
            'users.institution as institution',
            'users.position_id as position_id',
            'researchs.created_at as created_at'
        )
            ->leftjoin('presents', 'presents.id', '=', 'researchs.present_id')
            ->leftjoin('conferences', 'conferences.id', '=', 'researchs.conference_id')
            ->leftjoin('faculties', 'faculties.id', '=', 'researchs.faculty_id')
            ->leftjoin('status_researchs', 'status_researchs.id', '=', 'researchs.topic_status')
            ->leftjoin('users', 'users.id', 'researchs.user_id')
            ->where('conferences.status', 1)
            ->where('is_admin', 0)
            ->get();

        return view('frontend.pages.list_research', compact('researchs', 'conference'));
    }
}
