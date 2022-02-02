<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\Pdf;
use App\Models\Word;
use App\Models\Slip;

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
        $request->validate([
                'payment_upload' => 'file|mimes:jpg,jpeg|max:10240',
                'word_upload' => 'file|mimes:doc,docx|max:10240',
                'pdf_upload' => 'file|mimes:pdf|max:10240'
            ],
            [
                'pdf_upload.mimes' => 'อัพโหลด pdf เท่านั้น',
                'word_upload.mimes' => 'อัพโหลด doc, docx เท่านั้น',
                'payment_upload.mimes' => 'อัพโหลด jpg, jpeg เท่านั้น',
                'pdf_upload.max' => 'ไฟล์ต้องมีขนาดไม่เกิน 10 MB',
                'word_upload.max' => 'ไฟล์ต้องมีขนาดไม่เกิน 10 MB',
                'payment_upload.max' => 'ไฟล์ต้องมีขนาดไม่เกิน 10 MB',
            ]
        );

        $word_path = null;
        $pdf_path = null;
        $payment_path = null;
        
        if($request->file('pdf_upload')){
            $upload = $request->file('pdf_upload');
            $name = strval($id).".".$upload->extension();
            $pdf_path = $upload->storeAs('public/files/pdf', $name);

        } else if($request->file('word_upload')){
            $upload = $request->file('word_upload');
            $name = strval($id).".".$upload->extension();
            $word_path = $upload->storeAs('public/files/words', $name);

        } else if($request->file('payment_upload')){
            $upload = $request->file('payment_upload');
            $name = strval($id).".".$upload->extension();
            $payment_path = $upload->storeAs('public/files/slips', $name);
        }

        $path = isset($pdf_path) ? $pdf_path : (isset($word_path) ? $word_path : (isset($payment_path) ? $payment_path : null));
        $data = array_filter([
            'topic_id' => $id,
            'name' => $name,
            'path' => $path,
        ]);

        if($request->file('pdf_upload')){
            if(Pdf::where('topic_id', $id)->get()->count() === 0){
                Pdf::create($data);
            } else {
                Pdf::where('topic_id', $id)->update($data);
            }
        }
        
        if($request->file('word_upload')){
            if(Word::where('topic_id', $id)->get()->count() === 0){
                Word::create($data);
            } else {
                Word::where('topic_id', $id)->update($data);
            }
        }
        
        if($request->file('payment_upload')){
            if(Slip::where('topic_id', $id)->get()->count() === 0){
                Slip::create($data);
            } else {
                Slip::where('topic_id', $id)->update($data);
            }
        }

        return back()->with('success', true);
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