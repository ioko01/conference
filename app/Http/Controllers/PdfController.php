<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\Pdf;

class PdfController extends Controller
{

    protected function validation($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลด PDF ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        write_logs(__FUNCTION__, "error");
        return $request->validate(['pdf_upload' => 'required|mimes:pdf|max:10240']);
    }

    protected function file($request, $id = null)
    {
        $conference_year = Conference::where('id', auth()->user()->conference_id)->first();
        $result = new Pdf;
        $this->validation($request);
        $upload = $request->file('pdf_upload');
        $extension = $upload->extension();
        $name = strval($id) . "." . $extension;
        $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/บทความ/pdf';

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
        write_logs(__FUNCTION__, "info");
        return $result;
    }


    protected function store(Request $request, $id)
    {
        $pdf = Pdf::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'pdf.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $pdf);

        Pdf::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'อัพโหลด PDF สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'อัพโหลด PDF สำเร็จ');
    }

    protected function update(Request $request, $id)
    {
        Pdf::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไข PDF สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไข PDF สำเร็จ');
    }
}
