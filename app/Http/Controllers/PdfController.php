<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pdf;
use Illuminate\Support\Facades\Validator;

class PdfController extends Controller
{

    public function validation($request)
    {
        $validator = Validator::make($request->all(), ['pdf_upload' => 'required|mimes:pdf|max:10240']);
        return $validator;
    }

    public function file($request, $id = null)
    {
        $result = new Pdf;
        $validator = $this->validation($request);
        if (!$validator->fails()) {
            $upload = $request->file('pdf_upload');
            $extension = $upload->extension();
            $name = strval($id) . "." . $extension;
            $path = 'public/files/pdf';

            $data = array_filter([
                'user_id' => auth()->user()->id,
                'topic_id' => $id,
                'name' => $name,
                'path' => $path . "/" . $name,
                'extension' => $extension,
                'address' => $request->address,
                'date' => $request->date,
                'conference_id' => auth()->user()->conference_id
            ]);

            $result->data = $data;
            $result->upload = $upload->storeAs($path, $name);
            $result->validate = $validator->fails();

            return $result;
        } else {
            $result->validate = $validator;
            return $result;
        }
    }


    public function store(Request $request, $id)
    {
        $pdf = Pdf::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'pdf.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $pdf);

        if (!$this->file($request, $id)->validate) {
            Pdf::create($this->file($request, $id)->data);
            $this->file($request, $id)->upload;

            alert('สำเร็จ', 'อัพโหลด PDF สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'อัพโหลด PDF สำเร็จ');
        } else {
            alert('ผิดพลาด', $this->file($request, $id)->validate->errors()->messages()["pdf_upload"][0], 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('errors', $this->file($request, $id)->validate->errors()->messages()["pdf_upload"][0])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        if (!$this->file($request, $id)->validate) {
            Pdf::where('topic_id', $id)->update($this->file($request, $id)->data);
            $this->file($request, $id)->upload;

            alert('สำเร็จ', 'แก้ไข PDF สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'แก้ไข PDF สำเร็จ');
        } else {

            alert('ผิดพลาด', $this->file($request, $id)->validate->errors()->messages()["pdf_upload"][0], 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('errors', $this->file($request, $id)->validate->errors()->messages()["pdf_upload"][0])->withInput();
        }
    }
}
