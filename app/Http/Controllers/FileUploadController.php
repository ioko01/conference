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

        $path = null;
        
        if($request->file('pdf_upload')){
            $upload = $request->file('pdf_upload');
            $name = strval($id).".".$upload->extension();
            $path = 'public/files/pdf';

        } else if($request->file('word_upload')){
            $upload = $request->file('word_upload');
            $name = strval($id).".".$upload->extension();
            $path = 'public/files/words';

        } else if($request->file('payment_upload')){
            $upload = $request->file('payment_upload');
            $name = strval($id).".".$upload->extension();
            $path = 'public/files/slips';
            
        }

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path."/".$name,
        ]);

        if($request->file('pdf_upload')){
            if(Pdf::where('topic_id', $id)->get()->count() === 0){
                $pdf = Pdf::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'pdf.topic_id')->where('researchs.topic_id', $id)->first();
                $this->authorize('update', $pdf);

                Pdf::create($data);
            } else {
                Pdf::where('topic_id', $id)->update($data);
            }
            $upload->storeAs($path, $name);
        }
        
        if($request->file('word_upload')){
            if(Word::where('topic_id', $id)->get()->count() === 0){
                $word = Word::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'words.topic_id')->where('researchs.topic_id', $id)->first();
                $this->authorize('update', $word);

                Word::create($data);
            } else {
                Word::where('topic_id', $id)->update($data);
            }
            $upload->storeAs($path, $name);
        }
        
        if($request->file('payment_upload')){
            if(Slip::where('topic_id', $id)->get()->count() === 0){
                $slip = Slip::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'slips.topic_id')->where('researchs.topic_id', $id)->first();
                $this->authorize('update', $slip);
                
                Slip::create($data);
            } else {
                Slip::where('topic_id', $id)->update($data);

                
            }
            $upload->storeAs($path, $name);
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