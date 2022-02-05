<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\EditResearch;

class EditFileUploadController extends Controller
{
    public function update(Request $request, $id){
        $request->validate([
                'new_word' => 'mimes:doc,docx|max:10240',
                'new_pdf' => 'mimes:pdf|max:10240',
            ],
            [
                'new_word.mimes' => 'อัพโหลด pdf เท่านั้น',
                'new_pdf.mimes' => 'อัพโหลด doc, docx เท่านั้น',
                'new_word.max' => 'ไฟล์ต้องมีขนาดไม่เกิน 10 MB',
                'new_pdf.max' => 'ไฟล์ต้องมีขนาดไม่เกิน 10 MB',
            ]
        );

        $extension_word = null;
        $extension_pdf = null;
        $word = null;
        $pdf = null;
        $word_path = null;
        $pdf_path = null;
        $full_path_word = null;
        $full_path_pdf = null;
        $path = null;
        $name = null;
        if($request->file('new_word')){
            $upload = $request->file('new_word');
            $extension_word = $upload->extension();
            $word = strval($id)."_edit".".".$extension_word;
            $word_path = 'public/edit/words';
            $full_path_word = $word_path."/".$word;
            $path = $word_path;
            $name = $word;
        } else if($request->file('new_pdf')){
            $upload = $request->file('new_pdf');
            $extension_pdf = $upload->extension();
            $pdf = strval($id)."_edit".".".$extension_pdf;
            $pdf_path = 'public/edit/pdf';
            $full_path_pdf = $pdf_path."/".$pdf;
            $path = $pdf_path;
            $name = $pdf;
        }

        $user_id = Research::select('user_id')->where('topic_id', $id)->first();

        $data = array_filter([
            'user_id' => $user_id->user_id,
            'topic_id' => $id,
            'new_word' => $word,
            'new_pdf' => $pdf,
            'path_word' => $full_path_word,
            'path_pdf' => $full_path_pdf,
            'extension_word' => $extension_word,
            'extension_pdf' => $extension_pdf
        ]);

        if(EditResearch::where('topic_id', $id)->get()->count() === 0){
            EditResearch::create($data);
        } else {
            EditResearch::where('topic_id', $id)->update($data);
        }

        $upload->storeAs($path, $name);
       
        return back()->with('success', true);
    }
}