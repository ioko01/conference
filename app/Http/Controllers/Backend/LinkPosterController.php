<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Faculty;
use App\Models\LinkPoster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LinkPosterController extends Controller
{
    protected function validator($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'room' => 'required',
            'link' => 'required',
            'faculty_id' => 'required',
            'file' => 'mimes:jpg,jpeg,png|max:10240'
        ]);
    }

    public function index()
    {
        $faculties = Faculty::get();
        $link_posters = LinkPoster::select(
            'link_posters.id as id',
            'link_posters.room as room',
            'link_posters.link as link',
            'link_posters.name as name',
            'link_posters.path as path',
            'faculties.name as faculty_name'
        )
            ->leftjoin('conferences', 'conferences.id', 'link_posters.conference_id')
            ->leftjoin('faculties', 'faculties.id', 'link_posters.faculty_id')
            ->where('conferences.status', 1)
            ->get();
        foreach ($link_posters as $link_poster) {
            $link_poster->path = Storage::url($link_poster->path);
        }

        DB::disconnect('faculties');
        DB::disconnect('link_posters');
        return view('backend.pages.poster_link', compact('faculties', 'link_posters'));
    }

    protected function store(Request $request)
    {
        $conference = Conference::where('status', 1)->first();
        if (isset($conference->id)) {
            $upload = null;
            $extension = null;
            $name = null;
            $path = null;
            $full_path = null;

            $this->validator($request);

            $conference_year = Conference::where('id', auth()->user()->conference_id)->first();

            if ($request->hasFile('file')) {
                $upload = $request->file('file');
                $extension = $upload->extension();
                $name = "QR_" . $request->room . "." . $extension;
                $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/ไฟล์/qr_code_poster/qr_code_' . auth()->user()->conference_id;
                $full_path = $path . "/" . $name;

                $upload->storeAs($path, $name);
            }

            $data = array_filter([
                'room' => $request->room,
                'link' => $request->link,
                'faculty_id' => $request->faculty_id,
                'conference_id' => auth()->user()->conference_id,
                'user_id' => auth()->user()->id,
                'path' => $full_path,
                'extension' => $extension,
                'name' => $name
            ]);

            LinkPoster::create($data);

            write_logs(__FUNCTION__, "info");
            alert('สำเร็จ', 'เพิ่มลิงค์นำเสนอ Oral สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

            DB::disconnect('conferences');
            DB::disconnect('link_posters');
            return back()->with('success', true);
        } else {
            write_logs(__FUNCTION__, "error");
            alert('ผิดพลาด', 'ไม่มีการประชุมที่เปิดใช้งาน', 'error')->showConfirmButton('ปิด', '#3085d6');

            DB::disconnect('conferences');
            return back()->withErrors('ไม่มีการประชุมที่เปิดใช้งาน');
        }
    }

    public function edit($id)
    {
        $faculties = Faculty::get();
        $link_posters = LinkPoster::select(
            'link_posters.id as id',
            'link_posters.room as room',
            'link_posters.link as link',
            'link_posters.name as name',
            'link_posters.path as path',
            'faculties.name as faculty_name',
            'faculties.id as faculty_id'
        )
            ->leftjoin('conferences', 'conferences.id', 'link_posters.conference_id')
            ->leftjoin('faculties', 'faculties.id', 'link_posters.faculty_id')
            ->where('conferences.status', 1)
            ->get();

        $link_poster = LinkPoster::select(
            'link_posters.id as id',
            'link_posters.room as room',
            'link_posters.link as link',
            'link_posters.path as path',
            'faculties.name as faculty_name',
            'faculties.id as faculty_id'
        )
            ->leftjoin('conferences', 'conferences.id', 'link_posters.conference_id')
            ->leftjoin('faculties', 'faculties.id', 'link_posters.faculty_id')
            ->where('conferences.status', 1)
            ->where('link_posters.id', $id)
            ->first();
        foreach ($link_posters as $link_poster) {
            $link_poster->path = Storage::url($link_poster->path);
        }

        write_logs(__FUNCTION__, "info");

        DB::disconnect('faculties');
        DB::disconnect('link_posters');
        return view('backend.pages.edit_poster_link', compact('faculties', 'link_posters', 'link_poster'));
    }

    protected function update(Request $request, $id)
    {
        if (!auth()->user()->conference_id) {
            write_logs(__FUNCTION__, "error");
            alert('ผิดพลาด', 'ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->withErrors('ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้');
        }

        $link_poster = LinkPoster::find($id);
        $this->validator($request);

        if ($request->name_file != $link_poster->name) {
            if (Storage::exists($link_poster->path)) {
                write_logs(__FUNCTION__, "warning");
                Storage::delete($link_poster->path);
            }
        }

        $conference_year = Conference::where('id', auth()->user()->conference_id)->first();

        $upload = null;
        $extension = null;
        $name = null;
        $path = null;
        $fullpath = null;
        if ($request->hasFile('file')) {
            $upload = $request->file('file');
            $extension = $upload->extension();
            $name = "QR_" . $request->room . "." . $extension;
            $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/ไฟล์/qr_code_poster/qr_code_' . auth()->user()->conference_id;
            $fullpath = $path . "/" . $name;

            $upload->storeAs($path, $name);
        }


        if ($request->hasFile('file')) {
            $data = [
                'room' => $request->room,
                'link' => $request->link,
                'faculty_id' => $request->faculty_id,
                'conference_id' => auth()->user()->conference_id,
                'user_id' => auth()->user()->id,
                'path' => $fullpath,
                'extension' => $extension,
                'name' => $name
            ];
        } else {
            $data = [
                'room' => $request->room,
                'link' => $request->link,
                'faculty_id' => $request->faculty_id,
                'conference_id' => auth()->user()->conference_id,
                'user_id' => auth()->user()->id,
            ];
        }

        LinkPoster::where('id', $id)->update($data);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไข ลิงค์นำเสนอ Oral สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('conferences');
        DB::disconnect('link_posters');
        return back();
    }

    protected function destroy($id)
    {
        $link_poster = LinkPoster::find($id);
        if (Storage::exists($link_poster->path)) {
            Storage::delete($link_poster->path);
        }
        LinkPoster::where('id', $id)->delete();
        write_logs(__FUNCTION__, "warning");
        alert('สำเร็จ', 'ลบหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('link_posters');
        return redirect()->route('backend.posters.link.index');
    }
}
