<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\Word;
use Illuminate\Support\Facades\DB;

class WordController extends Controller
{
    protected function validation($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลด WORD ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(['word_upload' => 'required|mimes:doc,docx|max:10240']);
    }

    protected function file($request, $id = null)
    {
        $conference_year = Conference::where('id', auth()->user()->conference_id)->first();
        $result = new Word;
        $this->validation($request);

        $upload = $request->file('word_upload');
        $extension = $upload->extension();
        $name = strval($id) . "." . $extension;
        $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/บทความ/words';

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

        DB::disconnect('conferences');
        return $result;
    }

    protected function store(Request $request, $id)
    {
        $word = Word::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'words.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $word);
        Word::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'อัพโหลด WORD สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('words');
        return back()->with('success', 'อัพโหลด WORD สำเร็จ');
    }

    protected function update(Request $request, $id)
    {
        Word::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'อัพโหลด WORD สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('words');
        return back()->with('success', 'แก้ไข WORD สำเร็จ');
    }
}
