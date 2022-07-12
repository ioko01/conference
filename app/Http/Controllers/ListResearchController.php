<?php

namespace App\Http\Controllers;

use App\Models\Research;
use Illuminate\Http\Request;

class ListResearchController extends Controller
{
    public function index()
    {
        $researchs = Research::select(
            'researchs.topic_id as topic_id',
            'researchs.topic_th as topic_th',
            'researchs.presenter as presenter',
            'presents.name as present_name',
            'faculties.name as faculty_name',
            'status_researchs.name as topic_status',
            'researchs.topic_status as topic_status_id',
        )
            ->leftjoin('presents', 'presents.id', '=', 'researchs.present_id')
            ->leftjoin('conferences', 'conferences.id', '=', 'researchs.conference_id')
            ->leftjoin('faculties', 'faculties.id', '=', 'researchs.faculty_id')
            ->leftjoin('status_researchs', 'status_researchs.id', '=', 'researchs.topic_status')
            ->where('conferences.status', 1)
            ->get();
        return view('frontend.pages.list_research', compact('researchs'));
    }
}
