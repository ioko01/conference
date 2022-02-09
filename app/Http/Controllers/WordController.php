<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class WordController extends Controller
{
    public function validation($request){
        $request->validate(['word_upload' => 'required|mimes:doc,docx|max:10240']);
        return $request;
    }

    public function file($request, $id = null){
        $result = new Word;
        $this->validation($request);

        $upload = $request->file('word_upload');
        $extension = $upload->extension();
        $name = strval($id).".".$extension;
        $path = 'public/files/words';

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path."/".$name,
            'extension' => $extension,
            'address' => $request->address,
            'date' => $request->date
        ]);

        $result->data = $data;
        $result->upload = $upload->storeAs($path, $name);
        
        return $result;
    }

    public function store(Request $request, $id)
    {
        $word = Word::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'words.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $word);

        Word::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }

    public function update(Request $request, $id)
    {
        Word::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }
}