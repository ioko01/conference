<?php

namespace App\Http\Controllers\Backend;

use App\Exports\ExportResearch;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Degree;
use App\Models\Faculty;
use App\Models\Present;
use App\Models\Research;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ResearchController extends Controller
{
    public function index()
    {
        $researchs = Research::select(
            'researchs.id as id',
            'researchs.topic_id as topic_id',
            'researchs.topic_th as topic_th',
            'researchs.topic_en as topic_en',
            'researchs.presenter as presenter',
            'researchs.present_id as present_id',
            'researchs.created_at as created_at',
            'researchs.updated_at as updated_at',
            'users.person_attend as person_attend',
            'conferences.year as year'
        )
            ->leftjoin('users', 'users.id', '=', 'researchs.user_id')
            ->leftjoin('conferences', 'researchs.conference_id', '=', 'conferences.id')
            ->get();
        return view('backend.pages.researchs', compact('researchs'));
    }

    public function edit($id)
    {
        $faculties = Faculty::get();
        $degrees = Degree::get();
        $branches = Branch::get();
        $presents = Present::get();
        $research = Research::where('topic_id', $id)->first();

        return view('backend.pages.edit_research', compact('faculties', 'degrees', 'branches', 'presents', 'research'));
    }

    protected function validator($request)
    {
        return $request->validate([
            'topic_th' => 'required',
            'topic_en' => 'required',
            'presenters.0' => 'required',
            'faculty_id' => 'required',
            'branch_id' => 'required',
            'degree_id' => 'required',
            'present_id' => 'required',
        ]);
    }

    protected function update(Request $request, $id)
    {
        $this->validator($request);

        $presenters = join('|', array_filter($request->presenters));

        Research::where('topic_id', $id)->update([
            'topic_th' => $request->topic_th,
            'topic_en' => $request->topic_en,
            'presenter' => $presenters,
            'faculty_id' => $request->faculty_id,
            'branch_id' => $request->branch_id,
            'degree_id' => $request->degree_id,
            'present_id' => $request->present_id,
        ]);

        alert('สำเร็จ', 'แก้ไขบทความสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขบทความสำเร็จ');
    }

    protected function export(Request $request)
    {
        return Excel::download(new ExportResearch, 'EXPORT_RESEARCHS.xlsx');
    }
}
