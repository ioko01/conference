<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Faculty;
use App\Models\LinkOral;
use Illuminate\Http\Request;

class LinkOralController extends Controller
{

    protected function validator($request)
    {
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'room' => 'required',
            'link' => 'required',
            'faculty_id' => 'required'
        ]);
    }

    public function index()
    {
        $faculties = Faculty::get();
        $link_orals = LinkOral::select(
            'link_orals.id as id',
            'link_orals.room as room',
            'link_orals.link as link',
            'link_orals.path as path',
            'faculties.name as faculty_name'
        )
            ->leftjoin('conferences', 'conferences.id', 'link_orals.conference_id')
            ->leftjoin('faculties', 'faculties.id', 'link_orals.faculty_id')
            ->where('conferences.status', 1)
            ->get();
        return view('backend.pages.oral_link', compact('faculties', 'link_orals'));
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

            if ($request->hasFile('file')) {
                $upload = $request->file('file');
                $extension = $upload->extension();
                $name = "QR_" . $request->room . "." . $extension;
                $path = "public/oral/qr_code_" . auth()->user()->conference_id;
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
                'extension' => $extension

            ]);

            LinkOral::create($data);

            alert('สำเร็จ', 'เพิ่มลิงค์นำเสนอ Oral สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', true);
        } else {
            alert('ผิดพลาด', 'ไม่มีการประชุมที่เปิดใช้งาน', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->withErrors('ไม่มีการประชุมที่เปิดใช้งาน');
        }
    }

    public function edit($id)
    {
    }

    protected function update(Request $request, $id)
    {
    }

    protected function destroy($id)
    {
    }
}
