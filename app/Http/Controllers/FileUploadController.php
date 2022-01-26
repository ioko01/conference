<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Models\Research;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('frontend.pages.show_research');
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
        $request->validate([
            'payment-upload' => 'file|mimes:jpg,jpeg|max:10240',
            'word-upload' => 'file|mimes:doc,docx|max:10240',
            'pdf-upload' => 'file|mimes:pdf|max:10240'
        ],
        [
            'pdf-upload.mimes' => 'อัพโหลด pdf เท่านั้น'
        ]
    );

    $topicId = Research::select('topic_id')->where('user_id', auth()->user()->id)->get();
    if($request->file('pdf-upload')){
        $type = "Pdf";
        $upload = $request->file('pdf-upload');
        $path = $upload->storeAs('private/files/pdf', strval($topicId[0]->topic_id).".".$upload->extension());

    } else if($request->file('word-upload')){
        $type = "Word";
        $upload = $request->file('word-upload');
        $path = $upload->storeAs('private/files/words', strval($topicId[0]->topic_id).".".$upload->extension());

    } else if($request->file('payment-upload')){
        $type = "Slip";
        $upload = $request->file('payment-upload');
        $path = $upload->storeAs('private/files/slips', strval($topicId[0]->topic_id).".".$upload->extension());
    }

    return back()->with('success', 'Success, upload file '.$type);
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