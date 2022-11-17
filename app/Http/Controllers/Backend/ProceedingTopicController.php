<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\ProceedingTopic;
use Illuminate\Http\Request;

class ProceedingTopicController extends Controller
{
    public function index($year)
    {
        $topics = ProceedingTopic::select(
            'proceeding_topics.id as id',
            'proceeding_topics.topic as topic',
            'proceeding_topics.position as position'
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_topics.conference_id')
            ->where('conferences.year', $year)
            ->orderBy('proceeding_topics.position')
            ->get();
        $conference = Conference::where('year', $year)->orderBy('id', 'DESC')->first();
        return view('backend.pages.proceeding_topic', compact('year', 'topics', 'conference'));
    }

    protected function validator($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'topic' => 'required',
            'position' => 'required'
        ]);
    }

    protected function store(Request $request, $year)
    {
        $this->validator($request);
        $conference = Conference::where('year', $year)->first();

        $topic = ProceedingTopic::where('topic', $request->topic)->first();

        if ($topic) {
            alert('ผิดพลาด', 'มีหัวข้อนี้ในระบบแล้ว', 'error')->showConfirmButton('ปิด', '#3085d6');
        }

        ProceedingTopic::create([
            'conference_id' => $conference->id,
            'user_id' => auth()->user()->id,
            'topic' => $request->topic,
            'position' => $request->position
        ]);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'เพิ่มหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->back();
    }

    public function edit($year, $id)
    {
        $topics = ProceedingTopic::select(
            'proceeding_topics.id as id',
            'proceeding_topics.topic as topic',
            'proceeding_topics.position as position'
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_topics.conference_id')
            ->where('conferences.year', $year)
            ->orderBy('proceeding_topics.position')
            ->get();
        $topic = ProceedingTopic::select(
            'proceeding_topics.id as id',
            'proceeding_topics.topic as topic',
            'proceeding_topics.position as position'
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_topics.conference_id')
            ->where('conferences.year', $year)
            ->where('proceeding_topics.id', $id)
            ->first();
        write_logs(__FUNCTION__, "info");
        $conference = Conference::where('year', $year)->orderBy('id', 'DESC')->first();
        return view('backend.pages.edit_proceeding_topic', compact('year', 'topics', 'topic', 'conference'));
    }

    protected function update(Request $request, $year, $id)
    {
        $this->validator($request);
        $conference = Conference::where('year', $year)->first();

        $topic = ProceedingTopic::where('topic', $request->topic)->first();

        if ($topic) {
            alert('ผิดพลาด', 'มีหัวข้อนี้ในระบบแล้ว', 'error')->showConfirmButton('ปิด', '#3085d6');
        }

        ProceedingTopic::where('id', $id)->update([
            'conference_id' => $conference->id,
            'user_id' => auth()->user()->id,
            'topic' => $request->topic,
            'position' => $request->position
        ]);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไขหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->back();
    }

    protected function destroy($year, $id)
    {
        ProceedingTopic::leftjoin('conferences', 'conferences.id', 'proceeding_topics.conference_id')
            ->where('proceeding_topics.id', $id)
            ->where('conferences.year', $year)
            ->delete();
        write_logs(__FUNCTION__, "warning");
        alert('สำเร็จ', 'ลบหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->route('backend.proceeding.topic.index', $year);
    }
}
