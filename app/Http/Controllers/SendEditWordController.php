<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SendEditWord;

class SendEditWordController extends Controller
{
    protected function validation($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลด PDF ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(['word_upload' => 'required|mimes:doc,docx|max:10240']);
    }

    protected function file($request, $id = null)
    {
        $result = new SendEditWord;
        $this->validation($request);

        $upload = $request->file('word_upload');
        $extension = $upload->extension();
        $name = strval($id) . "_บทความแก้ไข." . $extension;
        $path = 'public/conference_id_' . auth()->user()->conference_id . '/บทความแก้ไข/words';

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
        $word = SendEditWord::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_words.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $word);

        SendEditWord::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        alert('สำเร็จ', 'อัพโหลดบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'อัพโหลดบทความแก้ไขสำเร็จ');
    }

    protected function update(Request $request, $id)
    {
        SendEditWord::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        alert('สำเร็จ', 'แก้ไขบทความแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขบทความแก้ไขสำเร็จ');
    }
}
