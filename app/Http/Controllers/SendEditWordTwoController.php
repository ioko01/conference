<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;

use App\Models\SendEditWordTwo;

class SendEditWordTwoController extends Controller
{
    protected function validation($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลด WORD ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(['word_upload' => 'required|mimes:doc,docx|max:10240']);
    }

    protected function file($request, $id = null)
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

        return $result;
    }


    protected function store(Request $request, $id)
    {
        $word = SendEditWordTwo::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_words_two.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $word);

        SendEditWordTwo::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        alert('สำเร็จ', 'อัพโหลดบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'อัพโหลดบทความแก้ไขสำเร็จ');
    }

    protected function update(Request $request, $id)
    {
        SendEditWordTwo::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        alert('สำเร็จ', 'แก้ไขบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขบทความแก้ไขสำเร็จ');
    }
}
