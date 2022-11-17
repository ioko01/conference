<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Research;
use App\Models\Comment;

class SendEditResearchTwoController extends Controller
{
    public function show($id)
    {
        $research = Research::select('users.id as id')
            ->rightjoin('users', 'users.id', 'researchs.user_id')
            ->where('users.id', $id)
            ->first();
        $this->authorize('view', $research);
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
            'researchs.topic_status as status_id',
            'send_edit_words.name as edit_word_name',
            'send_edit_words.path as edit_word_path',
            'send_edit_words.extension as edit_word_ext',
            'send_edit_words.updated_at as edit_word_update',
            'send_edit_pdf.name as edit_pdf_name',
            'send_edit_pdf.path as edit_pdf_path',
            'send_edit_pdf.extension as edit_pdf_ext',
            'send_edit_pdf.updated_at as edit_pdf_update',
            'send_edit_statements.name as edit_stm_name',
            'send_edit_statements.path as edit_stm_path',
            'send_edit_statements.extension as edit_stm_ext',
            'send_edit_statements.updated_at as edit_stm_update',
            'send_edit_words_two.name as edit_word_name_two',
            'send_edit_words_two.path as edit_word_path_two',
            'send_edit_words_two.extension as edit_word_ext_two',
            'send_edit_words_two.updated_at as edit_word_update_two',
            'send_edit_pdf_two.name as edit_pdf_name_two',
            'send_edit_pdf_two.path as edit_pdf_path_two',
            'send_edit_pdf_two.extension as edit_pdf_ext_two',
            'send_edit_pdf_two.updated_at as edit_pdf_update_two',
            'send_edit_statements_two.name as edit_stm_name_two',
            'send_edit_statements_two.path as edit_stm_path_two',
            'send_edit_statements_two.extension as edit_stm_ext_two',
            'send_edit_statements_two.updated_at as edit_stm_update_two',
            'conferences.status_payment as status_payment',
            'conferences.status_research_edit_two as status_research_edit_two'
        )
            ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
            ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
            ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
            ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
            ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
            ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
            ->leftjoin('status_researchs', 'researchs.topic_status', '=', 'status_researchs.id')
            ->leftjoin('send_edit_words', 'researchs.topic_id', '=', 'send_edit_words.topic_id')
            ->leftjoin('send_edit_pdf', 'researchs.topic_id', '=', 'send_edit_pdf.topic_id')
            ->leftjoin('send_edit_statements', 'researchs.topic_id', '=', 'send_edit_statements.topic_id')
            ->leftjoin('send_edit_words_two', 'researchs.topic_id', '=', 'send_edit_words_two.topic_id')
            ->leftjoin('send_edit_pdf_two', 'researchs.topic_id', '=', 'send_edit_pdf_two.topic_id')
            ->leftjoin('send_edit_statements_two', 'researchs.topic_id', '=', 'send_edit_statements_two.topic_id')
            ->leftjoin('conferences', 'conferences.id', '=', 'researchs.conference_id')
            ->where('researchs.user_id', $id)
            ->where('conferences.status', 1)
            ->get()
            ->sortBy('id');
        $comments = Comment::select(
            'comments.topic_id as comment_topic_id',
            'comments.name as comment_name',
            'comments.path as comment_path',
            'comments.extension as comment_ext',
            'comments.created_at as comment_update'
        )
            ->leftjoin('researchs', 'researchs.topic_id', '=', 'comments.topic_id')
            ->where('researchs.user_id', $id)
            ->get();
            
        return view('frontend.pages.send_edit_research_two', compact('data', 'comments'));
    }
}
