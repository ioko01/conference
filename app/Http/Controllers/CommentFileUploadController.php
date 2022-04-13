<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

class CommentFileUploadController extends Controller
{

    //Deleted All Files
    protected function destroyFile($path)
    {
        if (Storage::exists($path)) {
            Storage::deleteDirectory($path);
        }
    }
    protected function update(Request $request, $id)
    {
        $request->validate(['file_comment*' => 'mimes:pdf|max:10240']);

        $user = Research::select('user_id')->where('topic_id', $id)->first();
        if ($request->file('file_comment')) {

            foreach ($request->file('file_comment') as $key => $value) {
                $upload = $value;
                $extension = $upload->extension();
                $name = $upload->getClientOriginalName();
                $path = "public/comments/$id";
                $full_path = $path . "/" . $name;

                $data = array_filter([
                    'user_id' => $user->user_id,
                    'topic_id' => $id,
                    'name' => $name,
                    'path' => $full_path,
                    'extension' => $extension,
                    'conference_id' => auth()->user()->conference_id
                ]);

                if ($key == 0) {
                    Comment::where('name', '!=', $name)
                        ->where('topic_id', $id)
                        ->delete($data);
                }

                $comment = Comment::select('name')->where('topic_id', $id)->first();
                $count = Comment::select('name')->where('topic_id', $id)->count();

                if ($key == 0) {
                    $this->destroyFile($path);
                }

                if ($count == 0 || $comment->name != $name) {
                    Comment::create($data);
                } else if ($comment->name == $name) {
                    Comment::where('name', $name)
                        ->where('topic_id', $id)
                        ->update($data);
                }

                $upload->storeAs($path, $name);
            }
        }

        return back()->with('success', true);
    }
}
