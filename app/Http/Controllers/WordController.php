<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;

class WordController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {

        $request->validate(['word_upload' => 'required|mimes:doc,docx|max:10240']);

        $path = null;
        $extension = null;
        
        if($request->file('word_upload')){
            $upload = $request->file('word_upload');
            $extension = $upload->extension();
            $name = strval($id).".".$extension;
            $path = 'public/files/words';

        }

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path."/".$name,
            'extension' => $extension,
            'address' => $request->address,
            'date' => $request->date
        ]);
        
        if($request->file('word_upload')){
            if(Word::where('topic_id', $id)->get()->count() === 0){
                $word = Word::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'words.topic_id')->where('researchs.topic_id', $id)->first();
                $this->authorize('update', $word);

                Word::create($data);
            } else {
                Word::where('topic_id', $id)->update($data);
            }
            $upload->storeAs($path, $name);
        }

        return back()->with('success', true);
    }
}