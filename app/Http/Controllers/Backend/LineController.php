<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    //
    public function index()
    {
        $conferences = Conference::where('status', 1)->get();
        $lines = Line::select(
            'lines.id as id',
            'conferences.name as conference_name',
            'lines.link as line_link',
            'lines.name as line_name',
            'lines.path as line_path',
            'lines.extension as line_extension'
        )
            ->leftjoin('conferences', 'conferences.id', 'lines.conference_id')
            ->get();
        return view('backend.pages.line', compact('conferences', 'lines'));
    }

    protected function validator($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถเพิ่ม Line Openchat ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'conference_name' => 'required',
            'file' => 'mimes:jpg,jpeg,png|max:10240'
        ]);
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
                $name = "QR_OPENCHAT_" . auth()->user()->conference_id . "." . $extension;
                $path = "public/line_openchat";
                $full_path = $path . "/" . $name;

                $upload->storeAs($path, $name);
            }

            $data = array_filter([
                'conference_id' => auth()->user()->conference_id,
                'user_id' => auth()->user()->id,
                'name' => $name,
                'link' => $request->link,
                'path' => $full_path,
                'extension' => $extension
            ]);

            $conference = Line::select('conference_id')->where('conference_id', auth()->user()->conference_id)->first();
            if (isset($conference->conference_id)) {
                if ($conference->conference_id == auth()->user()->conference_id) {
                    alert('ผิดพลาด', 'ไม่สามารถเพิ่ม Line Openchat ในการประชุมครั้งนี้ได้อีก', 'error')->showConfirmButton('ปิด', '#3085d6');
                    return back()->withErrors('ไม่สามารถเพิ่ม Line Openchat ในการประชุมครั้งนี้ได้อีก');
                }
            }

            Line::create($data);

            alert('สำเร็จ', 'เพิ่ม Line Openchat สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', true);
        } else {
            alert('ผิดพลาด', 'ไม่มีการประชุมที่เปิดใช้งาน', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->withErrors('ไม่มีการประชุมที่เปิดใช้งาน');
        }
    }

    protected function edit($id)
    {
        $conferences = Conference::where('status', 1)->get();
        $lines = Line::select(
            'lines.id as id',
            'conferences.name as conference_name',
            'lines.link as line_link',
            'lines.name as line_name',
            'lines.path as line_path',
            'lines.extension as line_extension'
        )
            ->leftjoin('conferences', 'conferences.id', 'lines.conference_id')
            ->get();
        return view('backend.pages.edit_line', compact('conferences', 'lines'));
    }
}
