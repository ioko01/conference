<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;

class WordController extends Controller
{
    public function validation($request)
    {
        $validator = Validator::make($request->all(), ['word_upload' => 'required|mimes:doc,docx|max:10240']);
        return $validator;
    }

    public function file($request, $id = null)
    {
        $result = new Word;
        $validator = $this->validation($request);

        if (!$validator->fails()) {
            $upload = $request->file('word_upload');
            $extension = $upload->extension();
            $name = strval($id) . "." . $extension;
            $path = 'public/files/words';

            $data = array_filter([
                'user_id' => auth()->user()->id,
                'topic_id' => $id,
                'name' => $name,
                'path' => $path . "/" . $name,
                'extension' => $extension,
                'address' => $request->address,
                'date' => $request->date
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
        $word = Word::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'words.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $word);
        if (!$this->file($request, $id)->validate) {
            Word::create($this->file($request, $id)->data);
            $this->file($request, $id)->upload;

            alert('สำเร็จ', 'อัพโหลด WORD สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'อัพโหลด WORD สำเร็จ');
        } else {

            alert('ผิดพลาด', $this->file($request, $id)->validate->errors()->messages()["word_upload"][0], 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('errors', $this->file($request, $id)->validate->errors()->messages()["word_upload"][0])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        if (!$this->file($request, $id)->validate) {
            Word::where('topic_id', $id)->update($this->file($request, $id)->data);
            $this->file($request, $id)->upload;

            alert('สำเร็จ', 'อัพโหลด WORD สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'แก้ไข WORD สำเร็จ');
        } else {
            // dd($this->file($request, $id)->validate->errors()->messages());
            alert('ผิดพลาด', $this->file($request, $id)->validate->errors()->messages()["word_upload"][0], 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('errors', $this->file($request, $id)->validate->errors()->messages()['word_upload'][0])->withInput();
        }
    }
}
