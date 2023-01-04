<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Research;
use App\Models\StatusResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResearchPassedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Research::select(
            'researchs.id as id',
            'researchs.topic_id as topic_id',
            'researchs.research_passed as research_passed',
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
            'researchs.topic_status as status_id',
            'researchs.created_at as created_at',
            'researchs.updated_at as updated_at',
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
            ->leftjoin('conferences', 'researchs.conference_id', '=', 'conferences.id')
            ->where('conferences.status', 1)
            ->orderBy('id')
            ->get();

        DB::disconnect('researchs');
        return view('backend.pages.researchs_passed', compact('data'));
    }

    protected function update(Request $request, $id)
    {
        Research::where('topic_id', $id)->update(['research_passed' => $request->research_passed]);
        write_logs(__FUNCTION__, "info");

        DB::disconnect('researchs');
        return response()->json(['success' => true]);
    }
}
