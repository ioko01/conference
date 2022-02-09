<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pdf;

class PdfController extends Controller
{

    public function validation($request){
        $request->validate(['pdf_upload' => 'required|mimes:pdf|max:10240']);
        return $request;
    }

    public function file($request, $id = null){
        $result = new Pdf;
        $this->validation($request);

        $upload = $request->file('pdf_upload');
        $extension = $upload->extension();
        $name = strval($id).".".$extension;
        $path = 'public/files/pdf';

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path."/".$name,
            'extension' => $extension,
            'address' => $request->address,
            'date' => $request->date
        ]);

        $result->data = $data;
        $result->upload = $upload->storeAs($path, $name);
        
        return $result;
    }
    

    public function store(Request $request, $id)
    {
        $pdf = Pdf::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'pdf.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $pdf);

        Pdf::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }

    public function update(Request $request, $id)
    {
        Pdf::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }
}