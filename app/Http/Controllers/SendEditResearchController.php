<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Research;

class SendEditResearchController extends Controller
{
    public function show($id){
        $research = Research::
                            select('users.id as id')
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
                        )
                        ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
                        ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
                        ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
                        ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
                        ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
                        ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
                        ->leftjoin('status_researchs', 'researchs.topic_status', '=', 'status_researchs.id')
                        ->leftjoin('comments', 'researchs.topic_id', '=', 'comments.topic_id')
                        ->leftjoin('send_edit_words', 'researchs.topic_id', '=', 'send_edit_words.topic_id')
                        ->leftjoin('send_edit_pdf', 'researchs.topic_id', '=', 'send_edit_pdf.topic_id')
                        ->where('researchs.user_id', $id)
                        ->get()
                        ->sortBy('id');
        return view('frontend.pages.send_edit_research', compact('data'));
    }
}