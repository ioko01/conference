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
            'file_comment' => 'required|mimes:pdf,doc,docx|max:10240'
        ]);
    }


    protected function update(Request $request, $id)
    {
        $this->validation($request);

        $user = Research::select('user_id')->where('topic_id', $id)->first();
        $conference = Conference::where('id', auth()->user()->conference_id)->first();

        if ($request->hasfile('file_comment')) {
            $upload = $request->file('file_comment');
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
                'conference_id' => auth()->user()->conference_id,
                'status' => $request->inp_file_comment
            ]);

            // if ($key == 0) {
            //     Comment::where('name', '!=', $name)
            //         ->where('topic_id', $id)
            //         ->delete($data);
            // }

            $comment = Comment::select('name')
                ->where('name', $name)
                ->count();

            // if ($key == 0) {
            //     $this->destroyFile($path);
            // }
            if ($comment == 0) {
                Comment::create($data);
                // $status_research = StatusResearch::select('id')->where('name', 'ส่งบทความให้นักวิจัยแก้ไขแล้ว')->first();
                // Research::where('topic_id', $id)
                //     ->update(['topic_status' => $status_research->id]);
            } else {
                alert('ผิดพลาด', 'มีชื่อไฟล์นี้อยู่แล้ว ไม่สามารถอัพโหลดไฟล์ได้', 'error')->showConfirmButton('ปิด', '#3085d6');
                return back()->withErrors('มีชื่อไฟล์นี้อยู่แล้ว ไม่สามารถอัพโหลดไฟล์ได้');
                // Comment::where('name', $name)
                //     ->where('topic_id', $id)
                //     ->update($data);
            }


            $upload->storeAs($path, $name);
        }

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'ส่งไฟล์ไปให้นักวิจัยแก้ไขสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('conferences');
        DB::disconnect('researchs');
        DB::disconnect('comments');
        return back()->with('success', true);
    }

    public function get_comment_file($id)
    {
        $comments = Comment::select(
            'comments.id as comment_id',
            'comments.topic_id as comment_topic_id',
            'comments.name as comment_name',
            'comments.path as comment_path',
            'comments.extension as comment_ext',
            'comments.created_at as comment_update',
            'comments.status as comment_status'
        )
            ->leftjoin('researchs', 'researchs.topic_id', '=', 'comments.topic_id')
            ->where('comments.topic_id', '=', $id)
            ->get();

        DB::disconnect('comments');
        return response()->json($comments);
    }

    public function destroy($id)
    {
        $_comment = Comment::find($id);
        if (Storage::exists($_comment->path)) {
            Storage::delete($_comment->path);
        }
        Comment::where('id', $id)->delete();
        write_logs(__FUNCTION__, "warning");
        alert('สำเร็จ', 'ลบไฟล์สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('comments');
        return redirect()->route('backend.research.index');
    }
}
