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
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ResearchController extends Controller
{
    public function index()
    {
        $researchs = Research::select(
            'researchs.id as id',
            'researchs.note as note',
            'researchs.topic_id as topic_id',
            'researchs.topic_th as topic_th',
            'researchs.topic_en as topic_en',
            'researchs.presenter as presenter',
            'users.institution as institution',
            'researchs.created_at as created_at',
            'researchs.updated_at as updated_at',
            'users.fullname as fullname',
            'users.person_attend as person_attend',
            'presents.name as present',
            'conferences.year as year'
        )
            ->leftjoin('users', 'users.id', '=', 'researchs.user_id')
            ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
            ->leftjoin('conferences', 'researchs.conference_id', '=', 'conferences.id')
            ->get();

        DB::disconnect('researchs');
        return view('backend.pages.researchs', compact('researchs'));
    }

    public function edit($id)
    {
        $faculties = Faculty::get();
        $degrees = Degree::get();
        $branches = Branch::get();
        $presents = Present::get();
        $research = Research::where('topic_id', $id)->first();
        write_logs(__FUNCTION__, "info");

        $prefixs = [
            'นาย',
            'นาง',
            'นางสาว',
            'ดร.',
            'หม่อมเจ้า',
            'หม่อมราชวงศ์',
            'หม่อมหลวง',
            'หม่อม',
            'ท่านผู้หญิง',
            'คุณหญิง',
            'คุณ',
            'พระ',
            'พระมหา',
            'พลเอก',
            'พลโท',
            'พลตรี',
            'พันเอก(พิเศษ)',
            'พันเอก',
            'พันโท',
            'พันตรี',
            'ร้อยเอก',
            'ว่าที่พันตรี',
            'ร้อยโท',
            'ร้อยตรี',
            'ว่าที่ร้อยตรี',
            'จ่าสิบเอก',
            'จ่าสิบโท',
            'จ่าสิบตรี',
            'สิบเอก',
            'สิบโท',
            'สิบตรี',
            'พลเอกหญิง',
            'พลโทหญิง',
            'พลตรีหญิง',
            'พันเอก(พิเศษ)หญิง',
            'พันเอกหญิง',
            'พันโทหญิง',
            'พันตรีหญิง',
            'ร้อยเอกหญิง',
            'ร้อยโทหญิง',
            'ร้อยตรีหญิง',
            'ว่าที่ร้อยตรีหญิง',
            'จ่าสิบเอกหญิง',
            'จ่าสิบโทหญิง',
            'จ่าสิบตรีหญิง',
            'สิบเอกหญิง',
            'สิบโทหญิง',
            'สิบตรีหญิง',
            'พลเรือเอก',
            'พลเรือโท',
            'พลเรือตรี',
            'นาวาเอก(พิเศษ)',
            'นาวาเอก',
            'นาวาโท',
            'นาวาตรี',
            'เรือเอก',
            'เรือโท',
            'เรือตรี',
            'พันจ่าเอก',
            'พันจ่าโท',
            'พันจ่าตรี',
            'จ่าเอก',
            'จ่าโท',
            'จ่าตรี',
            'พลเรือเอกหญิง',
            'พลเรือโทหญิง',
            'พลเรือตรีหญิง',
            'นาวาเอก(พิเศษ)หญิง',
            'นาวาเอกหญิง',
            'นาวาโทหญิง',
            'นาวาตรีหญิง',
            'เรือเอกหญิง',
            'เรือโทหญิง',
            'เรือตรีหญิง',
            'พันจ่าเอกหญิง',
            'พันจ่าโทหญิง',
            'พันจ่าตรีหญิง',
            'ว่าที่เรือตรี',
            'จ่าเอกหญิง',
            'จ่าโทหญิง',
            'จ่าตรีหญิง',
            'พลอากาศเอก',
            'พลอากาศโท',
            'พลอากาศตรี',
            'นาวาอากาศเอก(พิเศษ)',
            'นาวาอากาศเอก',
            'นาวาอากาศโท',
            'นาวาอากาศตรี',
            'เรืออากาศเอก',
            'เรืออากาศโท',
            'เรืออากาศตรี',
            'พันจ่าอากาศเอก',
            'พันจ่าอากาศโท',
            'พันจ่าอากาศตรี',
            'จ่าอากาศเอก',
            'จ่าอากาศโท',
            'จ่าอากาศตรี',
            'พลอากาศเอกหญิง',
            'พลอากาศโทหญิง',
            'พลอากาศตรีหญิง',
            'นาวาอากาศเอก(พิเศษ)หญิง',
            'นาวาอากาศเอกหญิง',
            'นาวาอากาศโทหญิง',
            'นาวาอากาศตรีหญิง',
            'เรืออากาศเอกหญิง',
            'เรืออากาศโทหญิง',
            'เรืออากาศตรีหญิง',
            'พันจ่าอากาศเอกหญิง',
            'พันจ่าอากาศโทหญิง',
            'พันจ่าอากาศตรีหญิง',
            'จ่าอากาศเอกหญิง',
            'จ่าอากาศโทหญิง',
            'จ่าอากาศตรีหญิง',
            'พลตำรวจเอก',
            'พลตำรวจโท',
            'พลตำรวจตรี',
            'พันตำรวจเอก(พิเศษ)',
            'พันตำรวจเอก',
            'พันตำรวจโท',
            'พันตำรวจตรี',
            'ร้อยตำรวจเอก',
            'ร้อยตำรวจโท',
            'ร้อยตำรวจตรี',
            'ดาบตำรวจ',
            'จ่าสิบตำรวจ',
            'สิบตำรวจเอก',
            'สิบตำรวจโท',
            'สิบตำรวจตรี',
            'พลตำรวจเอกหญิง',
            'พลตำรวจโทหญิง',
            'พลตำรวจตรีหญิง',
            'พันตำรวจเอก(พิเศษ)หญิง',
            'พันตำรวจเอกหญิง',
            'พันตำรวจโทหญิง',
            'พันตำรวจตรีหญิง',
            'ร้อยตำรวจเอกหญิง',
            'ร้อยตำรวจโทหญิง',
            'ร้อยตำรวจตรีหญิง',
            'ดาบตำรวจหญิง',
            'จ่าสิบตำรวจหญิง',
            'สิบตำรวจเอกหญิง',
            'สิบตำรวจโทหญิง',
            'สิบตำรวจตรีหญิง',
            'ว่าที่ร้อยเอก',
            'ว่าที่ร้อยโท',
            'ศาสตราจารย์',
            'ศาสตราจารย์พิเศษ',
            'ศาสตราจารย์เกียรติคุณ',
            'รองศาสตราจารย์',
            'รองศาสตราจารย์พิเศษ',
            'ผู้ช่วยศาสตราจารย์',
            'ผู้ช่วยศาสตราจารย์พิเศษ',
        ];

        DB::disconnect('faculties');
        DB::disconnect('degrees');
        DB::disconnect('branches');
        DB::disconnect('presents');
        DB::disconnect('researchs');
        return view('backend.pages.edit_research', compact('faculties', 'degrees', 'branches', 'presents', 'research', 'prefixs'));
    }

    protected function validator($request)
    {
        write_logs(__FUNCTION__, "error");
        return $request->validate([
            'topic_th' => 'required',
            'topic_en' => 'required',
            'presenters.0' => 'required',
            'prefixs.0' => 'required',
            'faculty_id' => 'required',
            'branch_id' => 'required',
            'degree_id' => 'required',
            'present_id' => 'required',
        ]);
    }

    protected function update(Request $request, $id)
    {
        $this->validator($request);

        $prefix_presenter = [];
        foreach ($request->presenters as $key => $presenter) {
            if ($request->prefixs[$key]) {
                array_push($prefix_presenter, $request->prefixs[$key] . "!!" . $presenter);
            } elseif (!$request->prefixs[$key] && $presenter) {
                array_push($prefix_presenter, "!!" . $presenter);
            }
        }
        $presenters = join('|', array_filter($prefix_presenter));

        Research::where('topic_id', $id)->update([
            'topic_th' => $request->topic_th,
            'topic_en' => $request->topic_en,
            'presenter' => $presenters,
            'faculty_id' => $request->faculty_id,
            'branch_id' => $request->branch_id,
            'degree_id' => $request->degree_id,
            'present_id' => $request->present_id,
        ]);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไขบทความสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('researchs');
        return back()->with('success', 'แก้ไขบทความสำเร็จ');
    }

    protected function export()
    {
        write_logs(__FUNCTION__, "info");
        $date = date("d_m_Y");
        return Excel::download(new ExportResearch, "EXPORT_RESEARCHS_$date.xlsx");
    }
}
