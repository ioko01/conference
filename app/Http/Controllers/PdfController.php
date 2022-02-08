<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pdf;

class PdfController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {

        $request->validate(['pdf_upload' => 'required|mimes:pdf|max:10240']);

        $path = null;
        $extension = null;
        
        if($request->file('pdf_upload')){
            $upload = $request->file('pdf_upload');
            $extension = $upload->extension();
            $name = strval($id).".".$extension;
            $path = 'public/files/pdf';

        }

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path."/".$name,
            'extension' => $extension,
            'address' => $request->address,
            'date' => $request->date
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

        return back()->with('success', true);
    }
}
