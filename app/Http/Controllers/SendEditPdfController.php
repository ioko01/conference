<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SendEditPdf;

class SendEditPdfController extends Controller
{
    public function validation($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลด PDF ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(['pdf_upload' => 'required|mimes:pdf|max:10240']);
    }

    public function file($request, $id = null)
    {
        $result = new SendEditPdf;
        $this->validation($request);

        $upload = $request->file('pdf_upload');
        $extension = $upload->extension();
        $name = strval($id) . "_edit." . $extension;
        $path = 'public/edits/pdf';

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path . "/" . $name,
            'extension' => $extension,
            'conference_id' => auth()->user()->conference_id
        ]);

        $result->data = $data;
        $result->upload = $upload->storeAs($path, $name);

        return $result;
    }


    public function store(Request $request, $id)
    {
        $pdf = SendEditPdf::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_pdf.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $pdf);

        SendEditPdf::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        alert('สำเร็จ', 'อัพโหลดบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'อัพโหลดบทความแก้ไขสำเร็จ');
    }

    public function update(Request $request, $id)
    {
        SendEditPdf::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        alert('สำเร็จ', 'แก้ไขบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขบทความแก้ไขสำเร็จ');
    }
}
