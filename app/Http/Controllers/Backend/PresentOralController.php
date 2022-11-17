<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\PresentOral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresentOralController extends Controller
{
    protected function validator($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'topic_th' => 'required',
            'present_oral_id' => 'required',
            'faculty_id' => 'required'
        ]);
    }

    public function index()
    {
        $faculties = Faculty::get();
        $present_orals = PresentOral::select(
            'present_orals.id as id',
            'present_orals.topic_th as topic_th',
            'present_orals.present_oral_id as present_oral_id',
            'present_orals.time_start as time_start',
            'present_orals.time_end as time_end',
            'faculties.name as name',
        )
            ->leftjoin('faculties', 'faculties.id', 'present_orals.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'present_orals.conference_id')
            ->where('conferences.status', 1)
            ->orderBy(DB::raw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(present_oral_id , "0", ""),"1",""),"2",""),"3",""),"4",""),"5",""),"6",""),"7",""),"8",""),"9",""), LENGTH(present_oral_id)'))
            ->get();
        return view('backend.pages.oral', compact('faculties', 'present_orals'));
    }

    protected function store(Request $request)
    {
        $this->validator($request);
        $data = array_filter([
            'conference_id' => auth()->user()->conference_id,
            'user_id' => auth()->user()->id,
            'topic_th' => $request->topic_th,
            'present_oral_id' => $request->present_oral_id,
            'faculty_id' => $request->faculty_id,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end
        ]);
        PresentOral::create($data);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'เพิ่มผลงานนำเสนอ Oral สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'เพิ่มผลงานนำเสนอ Oral สำเร็จ');
    }

    public function edit($id)
    {
        $faculties = Faculty::get();
        $present_orals = PresentOral::select(
            'present_orals.id as id',
            'present_orals.topic_th as topic_th',
            'present_orals.present_oral_id as present_oral_id',
            'present_orals.time_start as time_start',
            'present_orals.time_end as time_end',
            'faculties.name as name',
        )
            ->leftjoin('faculties', 'faculties.id', 'present_orals.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'present_orals.conference_id')
            ->where('conferences.status', 1)
            ->orderBy(DB::raw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(present_oral_id , "0", ""),"1",""),"2",""),"3",""),"4",""),"5",""),"6",""),"7",""),"8",""),"9",""), LENGTH(present_oral_id)'))
            ->get();

        $present_oral = PresentOral::select(
            'present_orals.id as id',
            'present_orals.topic_th as topic_th',
            'present_orals.present_oral_id as present_oral_id',
            'present_orals.time_start as time_start',
            'present_orals.time_end as time_end',
            'present_orals.faculty_id as present_oral_faculty_id',
            'faculties.name as name',
        )
            ->leftjoin('faculties', 'faculties.id', 'present_orals.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'present_orals.conference_id')
            ->where('conferences.status', 1)
            ->where('present_orals.id', $id)
            ->first();
        write_logs(__FUNCTION__, "info");
        return view('backend.pages.edit_oral', compact('faculties', 'present_orals', 'present_oral'));
    }

    protected function update(Request $request, $id)
    {
        $this->validator($request);
        $data = array_filter([
            'conference_id' => auth()->user()->conference_id,
            'user_id' => auth()->user()->id,
            'topic_th' => $request->topic_th,
            'present_oral_id' => $request->present_oral_id,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'faculty_id' => $request->faculty_id
        ]);
        PresentOral::where('id', $id)->update($data);

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไขผลงานนำเสนอ Poster สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขผลงานนำเสนอ Poster สำเร็จ');
    }

    protected function destroy($id)
    {
        PresentOral::where('id', $id)->delete();
        write_logs(__FUNCTION__, "error");
        alert('สำเร็จ', 'ลบหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->route('backend.orals.index');
    }
}
