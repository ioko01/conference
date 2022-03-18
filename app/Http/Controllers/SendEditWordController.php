<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SendEditWord;

class SendEditWordController extends Controller
{
    public function validation($request){
        $request->validate(['word_upload' => 'required|mimes:doc,docx|max:10240']);
        return $request;
    }

    public function file($request, $id = null){
        $result = new SendEditWord;
        $this->validation($request);

        $upload = $request->file('word_upload');
        $extension = $upload->extension();
        $name = strval($id)."_edit.".$extension;
        $path = 'public/edits/words';

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path."/".$name,
            'extension' => $extension,
            'conference_id' => auth()->user()->conference_id
        ]);

        $result->data = $data;
        $result->upload = $upload->storeAs($path, $name);
        
        return $result;
    }
    

    public function store(Request $request, $id)
    {
        $word = SendEditWord::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_words.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $word);

        SendEditWord::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }

    public function update(Request $request, $id)
    {
        SendEditWord::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }
}
