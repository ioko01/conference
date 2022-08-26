<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SendEditStatementTwo;

class SendEditStatementTwoController extends Controller
{
    protected function validation($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลด แบบคำชี้แจงได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(['stm_upload' => 'required|mimes:pdf|max:10240']);
    }

    protected function file($request, $id = null)
    {
        $result = new SendEditStatementTwo;
        $this->validation($request);

        $upload = $request->file('stm_upload');
        $extension = $upload->extension();
        $name = strval($id) . "_แบบคำชี้แจงการปรับแก้ไขบทความครั้งที่_2." . $extension;
        $path = 'public/conference_id_' . auth()->user()->conference_id . '/บทความแก้ไขครั้งที่_2/แบบคำชี้แจงการปรับแก้ไขบทความ';

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


    protected function store(Request $request, $id)
    {
        $stm = SendEditStatementTwo::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_statements_two.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $stm);

        SendEditStatementTwo::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        alert('สำเร็จ', 'อัพโหลดบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'อัพโหลดบทความแก้ไขสำเร็จ');
    }

    protected function update(Request $request, $id)
    {
        SendEditStatementTwo::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        alert('สำเร็จ', 'แก้ไขบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขบทความแก้ไขสำเร็จ');
    }
}
