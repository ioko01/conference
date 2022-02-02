<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\StatusResearch;

class ManageResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topic_status = StatusResearch::get();
        $data = Research::
                        select('researchs.topic_id as topic_id', 'status_researchs.name as topic_status',
                        'topic_th', 'topic_en', 'presenter', 'faculties.name as faculty', 
                        'branches.name as branch', 'degrees.name as degree', 'presents.name as present', 
                        'users.phone as phone', 'users.institution as institution', 'users.address as address', 
                        'users.email as email', 'users.person_attend as attend', 'kotas.name as kota',
                        'words.name as word', 'pdf.name as pdf', 'slips.name as payment',
                        'slips.address as address_payment', 'slips.date as date_payment',
                        'words.path as word_path', 'pdf.path as pdf_path', 'slips.path as payment_path')
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
                        ->get();
        return view('frontend.pages.manage_research', compact('data', 'topic_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}