<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Faculty;
use App\Models\Present;
use App\Models\ProceedingResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProceedingResearchController extends Controller
{
    //
    public function index($year)
    {
        $researchs = ProceedingResearch::select(
            'proceeding_researchs.id as id',
            'proceeding_researchs.number as number',
            'proceeding_researchs.topic as topic',
            'proceeding_researchs.name as name',
            'proceeding_researchs.path as path',
            'proceeding_researchs.extension as extension',
            'faculties.name as faculty_name',
            'presents.name as present_name',
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_researchs.conference_id')
            ->leftjoin('faculties', 'faculties.id', 'proceeding_researchs.faculty_id')
            ->leftjoin('presents', 'presents.id', 'proceeding_researchs.present_id')
            ->where('conferences.year', $year)
            ->get();

        $faculties = Faculty::get();
        $presents = Present::get();

        return view('backend.pages.proceeding_research', compact('year', 'researchs', 'faculties', 'presents'));
    }

    protected function validator($request)
    {
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'faculty_id' => 'required',
            'present_id' => 'required',
            'number' => 'required',
            'topic' => 'required',
            'file' => 'mimes:pdf,doc,docx|max:10240'
        ]);
    }

    protected function store(Request $request, $year)
    {
        $this->validator($request);
        $conference = Conference::where('year', $year)->first();

        $upload = null;
        $extension = null;
        $name = null;
        $path = null;
        $fullpath = null;
        if ($request->hasFile('file')) {
            $upload = $request->file('file');
            $extension = $upload->extension();
            $file_name = "เลขหน้า_" . $request->number;
            $name = $file_name . '.' . $extension;
            $path = 'public/ประชุมวิชาการ ' . $year . '/proceeding (ห้ามลบ)/เผยแพร่ proceeding';
            $fullpath = $path . "/" . $name;
            $upload->storeAs($path, $name);
        }

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'faculty_id' => $request->faculty_id,
            'present_id' => $request->present_id,
            'number' => $request->number,
            'topic' => $request->topic,
            'name' => $name,
            'path' => $fullpath,
            'extension' => $extension,
            'conference_id' => $conference->id
        ]);

        ProceedingResearch::create($data);

        alert('สำเร็จ', 'สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->back();
    }

    public function edit($year, $id)
    {
        $researchs = ProceedingResearch::select(
            'proceeding_researchs.id as id',
            'proceeding_researchs.number as number',
            'proceeding_researchs.topic as topic',
            'proceeding_researchs.name as name',
            'proceeding_researchs.path as path',
            'proceeding_researchs.extension as extension',
            'faculties.name as faculty_name',
            'presents.name as present_name',
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_researchs.conference_id')
            ->leftjoin('faculties', 'faculties.id', 'proceeding_researchs.faculty_id')
            ->leftjoin('presents', 'presents.id', 'proceeding_researchs.present_id')
            ->where('conferences.year', $year)
            ->get();

        $_research = ProceedingResearch::select(
            'proceeding_researchs.id as id',
            'proceeding_researchs.number as number',
            'proceeding_researchs.topic as topic',
            'proceeding_researchs.name as name',
            'proceeding_researchs.path as path',
            'proceeding_researchs.extension as extension',
            'proceeding_researchs.faculty_id as faculty_id',
            'proceeding_researchs.present_id as present_id',
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_researchs.conference_id')
            ->leftjoin('faculties', 'faculties.id', 'proceeding_researchs.faculty_id')
            ->leftjoin('presents', 'presents.id', 'proceeding_researchs.present_id')
            ->where('conferences.year', $year)
            ->where('proceeding_researchs.id', $id)
            ->first();

        $faculties = Faculty::get();
        $presents = Present::get();

        return view('backend.pages.edit_proceeding_research', compact('year', 'researchs', 'faculties', 'presents', '_research'));
    }

    protected function update(Request $request, $year, $id)
    {

        $this->validator($request);
        $conference = Conference::where('year', $year)->first();

        $path_file = ProceedingResearch::find($id);

        $name_file = $path_file->name;

        if ($request->name_file != $name_file) {
            if (Storage::exists($path_file->path)) {
                Storage::delete($path_file->path);
            }
        }

        $upload = null;
        $extension = null;
        $name = null;
        $path = null;
        $fullpath = null;
        if ($request->hasFile('file')) {
            $upload = $request->file('file');
            $extension = $upload->extension();
            $file_name = "บทความไอดี_" . $id;
            $name = $file_name . '.' . $extension;
            $path = 'public/ประชุมวิชาการ ' . $year . '/proceeding (ห้ามลบ)/เผยแพร่ proceeding';
            $fullpath = $path . "/" . $name;
            $upload->storeAs($path, $name);
        }


        if ($request->file('file')) {
            $data = [
                'user_id' => auth()->user()->id,
                'faculty_id' => $request->faculty_id,
                'present_id' => $request->present_id,
                'number' => $request->number,
                'topic' => $request->topic,
                'name' => "เลขหน้า_" . $request->number . "." . $extension,
                'path' => $fullpath,
                'extension' => $extension,
                'conference_id' => $conference->id
            ];
        } else {
            $data = [
                'user_id' => auth()->user()->id,
                'faculty_id' => $request->faculty_id,
                'present_id' => $request->present_id,
                'number' => $request->number,
                'name' => "เลขหน้า_" . $request->number . "." . $path_file->extension,
                'topic' => $request->topic,
                'conference_id' => $conference->id
            ];
        }

        ProceedingResearch::where('id', $id)->update($data);
        alert('สำเร็จ', 'แก้ไขหัวข้อดาวน์โหลดไฟล์สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back();
    }

    protected function destroy($year, $id)
    {

        $path_file = ProceedingResearch::find($id);

        if (Storage::exists($path_file->path)) {
            Storage::delete($path_file->path);
        }

        ProceedingResearch::leftjoin('conferences', 'conferences.id', 'proceeding_researchs.conference_id')
            ->where('proceeding_researchs.id', $id)
            ->where('conferences.year', $year)
            ->delete();

        alert('สำเร็จ', 'ลบหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->route('backend.proceeding.research.index', $year);
    }
}
