<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{

    public function index()
    {

        $conferences = Conference::orderBy('id', 'DESC')->get();
        return view('backend.pages.conference', compact('conferences'));
    }

    public function validator($request)
    {
        return $request->validate([
            'topic' => 'required',
            'year' => 'required',
            'start' => 'required|date',
            'final' => 'required|date',
            'start_research' => 'required|date',
            'end_research' => 'required|date',
            'end_payment' => 'required|date',
            'end_attend' => 'required|date',
            'end_research_edit' => 'required|date',
            'end_research_edit_two' => 'required|date',
            'end_poster_and_video' => 'required|date',
            'end_poster_and_video_two' => 'required|date'
        ]);
    }

    public function store(Request $request)
    {

        $this->validator($request);

        Conference::create([
            'name' => $request->topic,
            'year' => $request->year,
            'start' => $request->start,
            'final' => $request->final,
            'start_research' => $request->start_research,
            'end_research' => $request->end_research,
            'end_payment' => $request->end_payment,
            'end_attend' => $request->end_attend,
            'end_research_edit' => $request->end_research_edit,
            'end_research_edit_two' => $request->end_research_edit_two,
            'end_poster_and_video' => $request->end_poster_and_video,
            'end_poster_and_video_two' => $request->end_poster_and_video_two
        ]);

        alert('สำเร็จ', 'เพิ่มหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'เพิ่มหัวข้อสำเร็จ');
    }

    public function update(Request $request, $id)
    {
        if ($request->change_status == 1) {
            $check_status = Conference::where('status', 1)->first();
            if ($check_status) {
                alert('ผิดพลาด', 'ไม่สามารถเปลี่ยนสถานะได้ เนื่องจากมีสถานะที่เปิดใช้งานอยู่แล้ว', 'error')->showConfirmButton('ปิด', '#3085d6');
                return back()->withErrors('ไม่สามารถเปลี่ยนสถานะได้ เนื่องจากมีสถานะที่เปิดใช้งานอยู่แล้ว');
            }
        }

        Conference::where('id', $id)->update(['status' => $request->change_status]);

        return back()->with('success', 'เปลี่ยนสถานะสำเร็จ');
    }

    public function destroy($id)
    {
    }
}
