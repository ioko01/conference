<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\User;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{

    public function index()
    {
        $conferences = Conference::orderBy('id', 'DESC')->get();
        return view('backend.pages.conference', compact('conferences'));
    }

    protected function validator($request)
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

    protected function store(Request $request)
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

    protected function update_topic(Request $request, $id)
    {
        $this->validator($request);

        Conference::where('id', $id)->update([
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

        alert('สำเร็จ', 'แก้ไขหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขหัวข้อสำเร็จ');
    }

    protected function update_status(Request $request, $id)
    {
        if ($request->change_status_conference == "1") {
            $check_status = Conference::where('status', 1)->first();
            if ($check_status) {
                alert('ผิดพลาด', 'ไม่สามารถเปลี่ยนสถานะได้ เนื่องจากมีสถานะที่เปิดใช้งานอยู่แล้ว', 'error')->showConfirmButton('ปิด', '#3085d6');
                return back()->withErrors('ไม่สามารถเปลี่ยนสถานะได้ เนื่องจากมีสถานะที่เปิดใช้งานอยู่แล้ว');
            }
        }

        $check_status = Conference::where('id', $id)
            ->where('status', 1)
            ->first();

        if (!$check_status && !$request->change_status_conference) {
            alert('ผิดพลาด', 'ไม่สามารถเปลี่ยนสถานะได้ เนื่องจากไม่ได้เปิดใช้งานการประชุมวิชาการ', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->withErrors('ไม่สามารถเปลี่ยนสถานะได้ เนื่องจากไม่ได้เปิดใช้งานการประชุมวิชาการ');
        }

        if ($request->change_status_conference == "0" && $check_status) {
            $change_status = array_filter([
                'status' => $request->change_status_conference,
                'status_research' => 0,
                'status_payment' => 0,
                'status_attend' => 0,
                'status_research_edit' => 0,
                'status_research_edit_two' => 0,
                'status_poster_and_video' => 0,
                'status_poster_and_video_two' => 0,
            ], 'is_numeric');
            User::where('id', auth()->user()->id)->update(['conference_id' => NULL]);
        } else {
            $change_status = array_filter([
                'status' => $request->change_status_conference,
                'status_research' => $request->change_status_research,
                'status_payment' => $request->change_status_payment,
                'status_attend' => $request->change_status_attend,
                'status_research_edit' => $request->change_status_research_edit,
                'status_research_edit_two' => $request->change_status_research_edit_two,
                'status_poster_and_video' => $request->change_status_poster_and_video,
                'status_poster_and_video_two' => $request->change_status_poster_and_video_two,
            ], 'is_numeric');
            User::where('id', auth()->user()->id)->update(['conference_id' => $id]);
        }

        Conference::where('id', $id)->update($change_status);
        

        alert('สำเร็จ', 'เปลี่ยนสถานะสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'เปลี่ยนสถานะสำเร็จ');
    }

    public function edit($id)
    {
        $conferences = Conference::orderBy('id', 'DESC')->get();
        $conference = Conference::find($id);
        return view('backend.pages.edit_conference', compact('conferences', 'conference'));
    }

    protected function destroy($id)
    {
    }
}
