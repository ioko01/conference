<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

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

        if($request->file('pdf-upload')){
            $upload = $request->file('pdf-upload');
        } else if($request->file('word-upload')){
            $upload = $request->file('word-upload');
        } else if($request->file('payment-upload')){
            $upload = $request->file('payment-upload');
        }
        
        $name = $upload->getClientOriginalName();
        $path = $upload->store('public/files');
        $save = new File;
 
        $save->name = $name;
        $save->path = $path;
            
        return back()->with('success', 'Success, upload file PDF');
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
