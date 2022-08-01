<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Models\StatusResearch;
use Illuminate\Http\Request;

class EditResearchFirstController extends Controller
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
            'send_edit_words.name as word',
            'send_edit_words.path as word_path',
            'send_edit_words.created_at as word_created_at',
            'send_edit_words.updated_at as word_updated_at',
            'send_edit_pdf.name as pdf',
            'send_edit_pdf.path as pdf_path',
            'send_edit_pdf.created_at as pdf_created_at',
            'send_edit_pdf.updated_at as pdf_updated_at',
            'send_edit_statements.name as statement',
            'send_edit_statements.path as statement_path',
            'send_edit_statements.created_at as statement_created_at',
            'send_edit_statements.updated_at as statement_updated_at',
            'researchs.topic_status as status_id'
        )
            ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
            ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
            ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
            ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
            ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
            ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
            ->rightjoin('send_edit_words', 'researchs.topic_id', '=', 'send_edit_words.topic_id')
            ->rightjoin('send_edit_pdf', 'researchs.topic_id', '=', 'send_edit_pdf.topic_id')
            ->rightjoin('send_edit_statements', 'researchs.topic_id', '=', 'send_edit_statements.topic_id')
            ->leftjoin('status_researchs', 'researchs.topic_status', '=', 'status_researchs.id')
            ->leftjoin('conferences', 'researchs.conference_id', '=', 'conferences.id')
            ->where('conferences.status', 1)
            ->get()
            ->sortBy('id');

        return view('backend.pages.show_edit_research_first', compact('data', 'topic_status'));
    }
}
