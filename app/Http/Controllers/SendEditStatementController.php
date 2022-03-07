<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SendEditStatement;

class SendEditStatementController extends Controller
{
    public function validation($request)
    {
        $request->validate(['stm_upload' => 'required|mimes:pdf|max:10240']);
        return $request;
    }

    public function file($request, $id = null)
    {
        $result = new SendEditStatement;
        $this->validation($request);

        $upload = $request->file('stm_upload');
        $extension = $upload->extension();
        $name = strval($id) . "_statement." . $extension;
        $path = 'public/edits/statements';

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path . "/" . $name,
            'extension' => $extension,
        ]);

        $result->data = $data;
        $result->upload = $upload->storeAs($path, $name);

        return $result;
    }


    public function store(Request $request, $id)
    {
        $stm = SendEditStatement::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'send_edit_statements.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $stm);

        SendEditStatement::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }

    public function update(Request $request, $id)
    {
        SendEditStatement::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }
}
