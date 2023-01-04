<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;

use App\Models\SendEditStatement;
use Illuminate\Support\Facades\DB;

class SendEditStatementController extends Controller
{
    protected function validation($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลด แบบคำชี้แจงได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(['stm_upload' => 'required|mimes:pdf|max:10240']);
    }

    protected function file($request, $id = null)
    {
        $conference_year = Conference::where('id', auth()->user()->conference_id)->first();
        $result = new SendEditStatement;
        $this->validation($request);

        $upload = $request->file('stm_upload');
        $extension = $upload->extension();
        $name = strval($id) . "_แบบคำชี้แจงการปรับแก้ไขบทความ." . $extension;
        $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/บทความแก้ไข/แบบคำชี้แจงการปรับแก้ไขบทความ';

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

        write_logs(__FUNCTION__, "info");

        DB::disconnect('conferences');
        return $result;
    }


    protected function store(Request $request, $id)
    {
        $stm = SendEditStatement::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_statements.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $stm);

        SendEditStatement::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'อัพโหลดบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('send_edit_statements');
        return back()->with('success', 'อัพโหลดบทความแก้ไขสำเร็จ');
    }

    protected function update(Request $request, $id)
    {
        SendEditStatement::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไขบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        DB::disconnect('send_edit_statements');
        return back()->with('success', 'แก้ไขบทความแก้ไขสำเร็จ');
    }
}
