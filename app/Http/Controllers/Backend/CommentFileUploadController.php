<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\Comment;
use App\Models\Conference;
use App\Models\StatusResearch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CommentFileUploadController extends Controller
{

    //Deleted All Files
    protected function destroyFile($path)
    {
        write_logs(__FUNCTION__, "warning");
        if (Storage::exists($path)) {
            Storage::deleteDirectory($path);
        }
    }

    protected function validation($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'ไม่สามารถส่งไฟล์ไปให้นักวิจัยแก้ไขได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'file_comment' => 'required',
            'file_comment.*' => 'mimes:pdf|max:10240'
        ]);
    }


    protected function update(Request $request, $id)
    {
        $this->validation($request);

        $user = Research::select('user_id')->where('topic_id', $id)->first();
        $conference = Conference::where('id', auth()->user()->conference_id)->first();

        if ($request->hasfile('file_comment')) {

            foreach ($request->file('file_comment') as $key => $file) {
                $upload = $file;
                $extension = $upload->extension();
                $name = $upload->getClientOriginalName();
                $path = 'public/ประชุมวิชาการ ' . $conference->year . '/ไฟล์คอมเมนต์' . '/' . $id;
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
                    $status_research = StatusResearch::select('id')->where('name', 'ส่งบทความให้นักวิจัยแก้ไขแล้ว')->first();
                    Research::where('topic_id', $id)
                        ->update(['topic_status' => $status_research->id]);
                } else if ($comment->name == $name) {
                    Comment::where('name', $name)
                        ->where('topic_id', $id)
                        ->update($data);
                }

                $upload->storeAs($path, $name);
            }
        }

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'ส่งไฟล์ไปให้นักวิจัยแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', true);
    }
}
