<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Research;

class EditResearchController extends Controller
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
                            'words.name as word', 
                            'pdf.name as pdf', 
                            'slips.name as payment',
                            'slips.address as address_payment', 
                            'slips.date as date_payment',
                            'words.path as word_path', 
                            'pdf.path as pdf_path', 
                            'slips.path as payment_path',
                            'slips.extension as slip_ext', 
                            'words.extension as word_ext', 
                            'pdf.extension as pdf_ext',
                            'slips.updated_at as slip_update', 
                            'words.updated_at as word_update',
                            'pdf.updated_at as pdf_update', 
                            'new_word', 
                            'new_pdf', 
                            'path_word', 
                            'path_pdf',
                            'extension_word as ext_word', 
                            'extension_pdf as ext_pdf', 
                            'edit_researchs.updated_at as edit_research_update', 
                            'researchs.topic_status as status_id'
                        )
                        ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
                        ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
                        ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
                        ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
                        ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
                        ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
                        ->leftjoin('words', 'researchs.topic_id', '=', 'words.topic_id')
                        ->leftjoin('pdf', 'researchs.topic_id', '=', 'pdf.topic_id')
                        ->leftjoin('slips', 'researchs.topic_id', '=', 'slips.topic_id')
                        ->leftjoin('status_researchs', 'researchs.topic_status', '=', 'status_researchs.id')
                        ->leftjoin('edit_researchs', 'researchs.topic_id', '=', 'edit_researchs.topic_id')
                        ->where('researchs.user_id', $id)
                        ->get()
                        ->sortBy('id');
        return view('frontend.pages.send_edit_research', compact('data'));
    }
}
