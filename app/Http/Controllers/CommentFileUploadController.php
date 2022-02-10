<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\Comment;

class CommentFileUploadController extends Controller
{
    public function update(Request $request, $id){
        $request->validate(['file_comment' => 'mimes:doc,docx,pdf|max:10240']);

        if($request->file('file_comment')){
            $upload = $request->file('file_comment');
            $extension = $upload->extension();
            $name = strval($id)."_comment".".".$extension;
            $path = 'public/comments';
            $full_path = $path."/".$name;
        }

        $user = Research::select('user_id')->where('topic_id', $id)->first();

        $data = array_filter([
            'user_id' => $user->user_id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $full_path,
            'extension' => $extension
        ]);

        if(Comment::where('topic_id', $id)->get()->count() === 0){
            Comment::create($data);
        } else {
            Comment::where('topic_id', $id)->update($data);
        }

        $upload->storeAs($path, $name);
       
        return back()->with('success', true);
    }
}