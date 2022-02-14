<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\Comment;

class CommentFileUploadController extends Controller
{
    public function update(Request $request, $id){
        $request->validate(['file_comment*' => 'mimes:pdf|max:10240']);

        $user = Research::select('user_id')->where('topic_id', $id)->first();
        if($request->file('file_comment')){
            
            foreach ($request->file('file_comment') as $key => $value) {
                $upload = $value;
                $extension = $upload->extension();
                $name = $upload->getClientOriginalName();
                $path = "public/comments/$id";
                $full_path = $path."/".$name;

                $data = array_filter([
                    'user_id' => $user->user_id,
                    'topic_id' => $id,
                    'name' => $name,
                    'path' => $full_path,
                    'extension' => $extension
                ]);

                if($key == 0){
                    Comment::where('topic_id', $id)->delete($data);
                }
                
                Comment::create($data);
                $upload->storeAs($path, $name);
            }
        }
       
        return back()->with('success', true);
    }
}