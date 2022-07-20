<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Models\StatusResearch;
use Illuminate\Http\Request;

class EditResearchSecondController extends Controller
{
    //
    public function index()
    {
        $topic_status = StatusResearch::get();
        $data = Research::select(
            'researchs.id as id',
            'researchs.topic_id as topic_id',
            'status_researchs.name as topic_status',
            'topic_th',
            'topic_en',
            'presenter',
            'faculties.name as faculty',
            'branches.name as branch',
            'degrees.name as degree',
            'presents.name as present',
            'users.phone as phone',
            'users.institution as institution',
            'users.address as address',
            'users.email as email',
            'users.person_attend as attend',
            'kotas.name as kota',
            'send_edit_words_two.name as word',
            'send_edit_words_two.path as word_path',
            'send_edit_words_two.created_at as word_created_at',
            'send_edit_words_two.updated_at as word_updated_at',
            'send_edit_pdf_two.name as pdf',
            'send_edit_pdf_two.path as pdf_path',
            'send_edit_pdf_two.created_at as pdf_created_at',
            'send_edit_pdf_two.updated_at as pdf_updated_at',
            'send_edit_statements_two.name as statement',
            'send_edit_statements_two.path as statement_path',
            'send_edit_statements_two.created_at as statement_created_at',
            'send_edit_statements_two.updated_at as statement_updated_at',
            'researchs.topic_status as status_id'
        )
            ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
            ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
            ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
            ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
            ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
            ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
            ->leftjoin('send_edit_words_two', 'researchs.topic_id', '=', 'send_edit_words_two.topic_id')
            ->leftjoin('send_edit_pdf_two', 'researchs.topic_id', '=', 'send_edit_pdf_two.topic_id')
            ->leftjoin('send_edit_statements_two', 'researchs.topic_id', '=', 'send_edit_statements_two.topic_id')
            ->leftjoin('status_researchs', 'researchs.topic_status', '=', 'status_researchs.id')
            ->leftjoin('conferences', 'researchs.conference_id', '=', 'conferences.id')
            ->where('conferences.status', 1)
            ->get()
            ->sortBy('id');

        return view('backend.pages.show_edit_research_second', compact('data', 'topic_status'));
    }
}
