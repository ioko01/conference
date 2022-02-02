<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;

class ManageResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Research::
                        select('researchs.user_id as user_id', 'researchs.topic_id as topic_id', 'topic_th', 'topic_en', 'presenter', 'faculties.name as faculty', 
                        'branches.name as branch', 'degrees.name as degree', 'presents.name as present', 
                        'users.phone as phone', 'users.institution as institution', 'users.address as address', 
                        'users.email as email', 'users.person_attend as attend', 'kotas.name as kota',
                        'files.file_word as word', 'files.file_pdf as pdf', 'files.file_payment as payment',
                        'files.address_payment as address_payment', 'files.date_payment as date_payment')
                        ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
                        ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
                        ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
                        ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
                        ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
                        ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
                        ->leftjoin('files', 'researchs.topic_id', '=', 'files.topic_id')
                        ->get();
        return view('frontend.pages.manage_research', compact('data'));
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