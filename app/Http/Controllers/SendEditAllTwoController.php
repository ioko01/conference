<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\SendEditPdfTwo;
use App\Models\SendEditStatementTwo;
use App\Models\SendEditWordTwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendEditAllTwoController extends Controller
{
    protected function validation($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลดได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(
            [
                'word_upload' => 'required|mimes:doc,docx|max:10240',
                'pdf_upload' => 'required|mimes:pdf|max:10240',
                'stm_upload' => 'required|mimes:pdf,doc,docx|max:10240',
            ]
        );
    }

    protected function file_word($request, $id = null)
    {
        $conference_year = Conference::where('id', auth()->user()->conference_id)->first();
        $result = new SendEditWordTwo;
        $this->validation($request);

        $upload = $request->file('word_upload');
        $extension = $upload->extension();
        $name = strval($id) . "_บทความแก้ไขครั้งที่_2." . $extension;
        $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/บทความแก้ไขครั้งที่_2/words';

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

    protected function file_pdf($request, $id = null)
    {
        $conference_year = Conference::where('id', auth()->user()->conference_id)->first();
        $result = new SendEditPdfTwo;
        $this->validation($request);

        $upload = $request->file('pdf_upload');
        $extension = $upload->extension();
        $name = strval($id) . "_บทความแก้ไขครั้งที่_2." . $extension;
        $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/บทความแก้ไขครั้งที่_2/pdf';

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

    protected function file_stm($request, $id = null)
    {
        $conference_year = Conference::where('id', auth()->user()->conference_id)->first();
        $result = new SendEditStatementTwo;
        $this->validation($request);

        $upload = $request->file('stm_upload');
        $extension = $upload->extension();
        $name = strval($id) . "_แบบคำชี้แจงการปรับแก้ไขบทความ." . $extension;
        $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/บทความแก้ไขครั้งที่_2/แบบคำชี้แจงการปรับแก้ไขบทความ';

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
        $word = SendEditWordTwo::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_words_two.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $word);

        $pdf = SendEditPdfTwo::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_pdf_two.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $pdf);

        $stm = SendEditStatementTwo::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_statements_two.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $stm);

        SendEditWordTwo::create($this->file_word($request, $id)->data);
        $this->file_word($request, $id)->upload;

        SendEditPdfTwo::create($this->file_pdf($request, $id)->data);
        $this->file_pdf($request, $id)->upload;

        SendEditStatementTwo::create($this->file_stm($request, $id)->data);
        $this->file_stm($request, $id)->upload;

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'อัพโหลดบทความแก้ไขครั้งที่ 2 สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('send_edit_words_two');
        DB::disconnect('send_edit_pdf_two');
        DB::disconnect('send_edit_statements_two');
        return back()->with('success', 'อัพโหลดบทความแก้ไขครั้งที่ 2 สำเร็จ');
    }

    protected function update(Request $request, $id)
    {
        SendEditWordTwo::where('topic_id', $id)->update($this->file_word($request, $id)->data);
        $this->file_word($request, $id)->upload;

        SendEditPdfTwo::where('topic_id', $id)->update($this->file_pdf($request, $id)->data);
        $this->file_pdf($request, $id)->upload;

        SendEditStatementTwo::where('topic_id', $id)->update($this->file_stm($request, $id)->data);
        $this->file_stm($request, $id)->upload;

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไขบทความแก้ไขครั้งที่ 2 สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('send_edit_words_two');
        DB::disconnect('send_edit_pdf_two');
        DB::disconnect('send_edit_statements_two');
        return back()->with('success', 'แก้ไขบทความแก้ไขครั้งที่ 2 สำเร็จ');
    }
}
