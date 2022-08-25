<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Poster;
use App\Models\PresentPoster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PresentPosterController extends Controller
{

    protected function validator($request)
    {
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'topic_th' => 'required',
            'present_poster_id' => 'required',
            'faculty_id' => 'required'
        ]);
    }


    public function index()
    {
        $faculties = Faculty::get();
        $present_posters = PresentPoster::select(
            'present_posters.id as id',
            'present_posters.topic_th as topic_th',
            'present_posters.present_poster_id as present_poster_id',
            'present_posters.link as link',
            'present_posters.path as path',
            'faculties.name as name',
        )
            ->leftjoin('faculties', 'faculties.id', 'present_posters.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'present_posters.conference_id')
            ->where('conferences.status', 1)
            ->get();

        foreach ($present_posters as $present_poster) {
            $present_poster->path = Storage::url($present_poster->path);
        }
        return view('backend.pages.poster', compact('faculties', 'present_posters'));
    }

    protected function store(Request $request)
    {
        $this->validator($request);
        $poster = Poster::where('topic_id', $request->topic_id)->first();
        $data = array_filter([
            'conference_id' => auth()->user()->conference_id,
            'user_id' => auth()->user()->id,
            'topic_th' => $request->topic_th,
            'present_poster_id' => $request->present_poster_id,
            'faculty_id' => $request->faculty_id,
            'link' => $request->link ? $request->link : $request->video_link,
            'path' => $poster->path,
            'extension' => $poster->extension
        ]);
        PresentPoster::create($data);

        alert('สำเร็จ', 'เพิ่มผลงานนำเสนอ Poster สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'เพิ่มผลงานนำเสนอ Poster สำเร็จ');
    }

    protected function edit($id)
    {
        $faculties = Faculty::get();
        $present_posters = PresentPoster::select(
            'present_posters.id as id',
            'present_posters.topic_th as topic_th',
            'present_posters.present_poster_id as present_poster_id',
            'present_posters.link as link',
            'present_posters.path as path',
            'faculties.name as name',
        )
            ->leftjoin('faculties', 'faculties.id', 'present_posters.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'present_posters.conference_id')
            ->where('conferences.status', 1)
            ->get();

        $present_poster = PresentPoster::select(
            'present_posters.id as id',
            'present_posters.topic_th as topic_th',
            'present_posters.present_poster_id as present_poster_id',
            'present_posters.link as link',
            'present_posters.path as path',
            'present_posters.faculty_id as present_poster_faculty_id',
            'faculties.name as name',
        )
            ->leftjoin('faculties', 'faculties.id', 'present_posters.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'present_posters.conference_id')
            ->where('conferences.status', 1)
            ->where('present_posters.id', $id)
            ->first();

        foreach ($present_posters as $present_poster) {
            $present_poster->path = Storage::url($present_poster->path);
        }
        return view('backend.pages.edit_poster', compact('faculties', 'present_posters', 'present_poster'));
    }

    protected function update(Request $request, $id)
    {
        $this->validator($request);
        $data = array_filter([
            'conference_id' => auth()->user()->conference_id,
            'user_id' => auth()->user()->id,
            'topic_th' => $request->topic_th,
            'present_poster_id' => $request->present_poster_id,
            'faculty_id' => $request->faculty_id,
            'link' => $request->link ? $request->link : $request->video_link
        ]);
        PresentPoster::where('id', $id)->update($data);

        alert('สำเร็จ', 'แก้ไขผลงานนำเสนอ Poster สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขผลงานนำเสนอ Poster สำเร็จ');
    }

    protected function destroy($id)
    {
        PresentPoster::where('id', $id)->delete();
        alert('สำเร็จ', 'ลบหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->route('backend.posters.index');
    }
}
