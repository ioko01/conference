<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Research;
use App\Models\Comment;
use App\Models\Conference;
use App\Models\Poster;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class UploadfileController extends Controller
{
    public function show($id)
    {
        $conference = Conference::where('status', 1)->first();
        $research = Research::select('users.id as id')
            ->rightjoin('users', 'users.id', 'researchs.user_id')
            ->where('users.id', $id)
            ->first();
        $this->authorize('view', $research);
        $data = Research::select(
            'researchs.id as id',
            'researchs.topic_id as topic_id',
            'status_researchs.name as topic_status',
            'topic_th',
            'topic_en',
            'presenter',
            'faculties.name as faculty',
            'branches.name as branch',
            'degrees.name as degree',
            'presents.name as present',
            'users.phone as phone',
            'users.institution as institution',
            'users.address as address',
            'users.email as email',
            'users.person_attend as attend',
            'kotas.name as kota',
            'words.name as word',
            'pdf.name as pdf',
            'slips.name as payment',
            'slips.address as address_payment',
            'slips.date as date_payment',
            'words.path as word_path',
            'pdf.path as pdf_path',
            'slips.path as payment_path',
            'slips.extension as slip_ext',
            'words.extension as word_ext',
            'pdf.extension as pdf_ext',
            'slips.updated_at as slip_update',
            'words.updated_at as word_update',
            'pdf.updated_at as pdf_update',
            'researchs.topic_status as status_id',
            'videos.link as video_link',
            'posters.path as poster_path',
            'posters.name as poster_name',
            'conferences.status_poster_and_video as status_poster_and_video',
            'conferences.end_poster_and_video as end_poster_and_video'
        )
            ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
            ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
            ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
            ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
            ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
            ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
            ->leftjoin('words', 'researchs.topic_id', '=', 'words.topic_id')
            ->leftjoin('pdf', 'researchs.topic_id', '=', 'pdf.topic_id')
            ->leftjoin('slips', 'researchs.topic_id', '=', 'slips.topic_id')
            ->leftjoin('status_researchs', 'researchs.topic_status', '=', 'status_researchs.id')
            ->leftjoin('videos', 'researchs.topic_id', '=', 'videos.topic_id')
            ->leftjoin('posters', 'researchs.topic_id', '=', 'posters.topic_id')
            ->leftjoin('conferences', 'researchs.conference_id', '=', 'conferences.id')
            ->where('researchs.user_id', $id)
            ->where('conferences.status', 1)
            ->get()
            ->sortBy('id');

        $comments = Comment::select(
            'comments.topic_id as comment_topic_id',
            'comments.name as comment_name',
            'comments.path as comment_path',
            'comments.extension as comment_ext',
            'comments.created_at as comment_update'
        )
            ->leftjoin('researchs', 'researchs.topic_id', '=', 'comments.topic_id')
            ->where('researchs.user_id', $id)
            ->get();

        foreach ($data as $present_poster) {
            $present_poster->poster_path = Storage::url($present_poster->poster_path);
        }
        return view('frontend.pages.uploadfile', compact('data', 'comments', 'conference'));
    }

    protected function validation($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลดไฟล์ Poster ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(['poster' => 'required|mimes:jpg,jpeg|max:10240']);
    }

    protected function video_validation($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถทำรายการได้ กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(['video' => 'required']);
    }

    protected function poster_validation($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถทำรายการได้ กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(['poster' => 'required|mimes:jpg,jpeg|max:10240']);
    }

    protected function file($request, $id = null)
    {
        $result = new Poster;
        $this->validation($request);

        $upload = $request->file('poster');
        $extension = $upload->extension();
        $name = strval($id) . "." . $extension;
        $path = 'public/files/posters/conference_id_' . auth()->user()->conference_id;

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path . "/" . $name,
            'extension' => $extension,
            'conference_id' => auth()->user()->conference_id
        ]);

        $result->data = $data;
        $result->upload = $upload->storeAs($path, $name);

        return $result;
    }

    protected function store(Request $request, $id)
    {

        if ($request->video) {
            $this->video_validation($request);

            $data = array_filter([
                'user_id' => auth()->user()->id,
                'topic_id' => $id,
                'link' => $request->video,
                'conference_id' => auth()->user()->conference_id
            ]);
            Video::create($data);
            alert('สำเร็จ', 'อัพโหลด Link Video สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'อัพโหลด Link Video สำเร็จ');
        } else if ($request->poster) {
            $this->poster_validation($request);

            Poster::create($this->file($request, $id)->data);
            $this->file($request, $id)->upload;
            alert('สำเร็จ', 'อัพโหลด ไฟล์ Poster สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'อัพโหลดไฟล์ Poster สำเร็จ');
        }
        return back();
    }

    protected function update(Request $request, $id)
    {
        if ($request->submit_video) {
            $this->video_validation($request);

            $data = array_filter(['link' => $request->video]);
            Video::where('topic_id', $id)->update($data);
            alert('สำเร็จ', 'แก้ไข Link Video สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'แก้ไข Link Video สำเร็จ');
        } else if ($request->submit_poster) {
            $this->poster_validation($request);

            Poster::where('topic_id', $id)->update($this->file($request, $id)->data);
            $this->file($request, $id)->upload;
            alert('สำเร็จ', 'แก้ไขไฟล์ Poster สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'แก้ไขไฟล์ Poster สำเร็จ');
        }
    }
}
