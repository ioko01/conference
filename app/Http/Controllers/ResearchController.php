<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\Faculty;
use App\Models\Degree;
use App\Models\Branch;
use App\Models\Present;
use App\Models\Tip;
use App\Models\Comment;
use App\Models\Conference;
use Illuminate\Support\Facades\DB;

class ResearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $faculties = Faculty::get();
        $degrees = Degree::get();
        $branches = Branch::get();
        $presents = Present::get();
        $tips = Tip::where('group', '1')->get();
        $conference_id = Conference::where('status_research', 1)->first();

        $prefixs = [
            'นาย',
            'นาง',
            'นางสาว',
            'หม่อมเจ้า',
            'หม่อมราชวงศ์',
            'หม่อมหลวง',
            'หม่อม',
            'ท่านผู้หญิง',
            'คุณหญิง',
            'คุณ',
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
        DB::disconnect('tips');
        DB::disconnect('conferences');
        return view('frontend.pages.send_research', compact('faculties', 'degrees', 'branches', 'presents', 'tips', 'conference_id', 'prefixs'));
    }

    protected function validator($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
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

    public function create(array $data)
    {
    }

    protected function store(Request $request)
    {
        $this->validator($request);
        $prefix_presenter = [];
        foreach ($request->presenters as $key => $presenter) {
            if ($presenter) {
                array_push($prefix_presenter, $request->prefixs[$key] . "!!" . $presenter);
            }
        }
        $presenters = join('|', array_filter($prefix_presenter));
        $conference = Conference::where('status', 1)->first();

        $topic_id = (intval($conference->year) - 2500) . sprintf("%03d", Research::count() + 1);
        Research::create([
            'user_id' => auth()->user()->id,
            'topic_id' => $topic_id,
            'topic_th' => $request->topic_th,
            'topic_en' => $request->topic_en,
            'presenter' => $presenters,
            'faculty_id' => $request->faculty_id,
            'branch_id' => $request->branch_id,
            'degree_id' => $request->degree_id,
            'present_id' => $request->present_id,
            'conference_id' => auth()->user()->conference_id
        ]);

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'เพิ่มบทความเรียบร้อย', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('conferences');
        DB::disconnect('researchs');
        return redirect()->route('employee.research.show', auth()->user()->id)->with('success', true);
    }

    public function show($id)
    {
        $conference = Conference::where('status', 1)->first();
        $research = Research::select('users.id as id')
            ->rightjoin('users', 'users.id', 'researchs.user_id')
            ->where('users.id', $id)
            ->first();
        $this->authorize('view', $research);
        $data = Research::select(
            'researchs.id as id',
            'researchs.topic_id as topic_id',
            'researchs.created_at as created_at',
            'status_researchs.name as topic_status',
            'topic_th',
            'topic_en',
            'presenter',
            'faculties.name as faculty',
            'branches.name as branch',
            'degrees.name as degree',
            'presents.name as present',
            'users.phone as phone',
            'users.institution as institution',
            'users.address as address',
            'users.email as email',
            'users.person_attend as attend',
            'users.position_id as position_id',
            'kotas.name as kota',
            'words.name as word',
            'pdf.name as pdf',
            'slips.name as payment',
            'slips.address as address_payment',
            'slips.date as date_payment',
            'words.path as word_path',
            'pdf.path as pdf_path',
            'slips.path as payment_path',
            'slips.extension as slip_ext',
            'words.extension as word_ext',
            'pdf.extension as pdf_ext',
            'slips.updated_at as slip_update',
            'words.updated_at as word_update',
            'pdf.updated_at as pdf_update',
            'researchs.topic_status as status_id',
            'conferences.status as status_id_conference',
            'conferences.status_payment as status_payment',
            'conferences.status_research as status_research'
        )
            ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
            ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
            ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
            ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
            ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
            ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
            ->leftjoin('words', 'researchs.topic_id', '=', 'words.topic_id')
            ->leftjoin('pdf', 'researchs.topic_id', '=', 'pdf.topic_id')
            ->leftjoin('slips', 'researchs.topic_id', '=', 'slips.topic_id')
            ->leftjoin('status_researchs', 'researchs.topic_status', '=', 'status_researchs.id')
            ->leftjoin('conferences', 'researchs.conference_id', '=', 'conferences.id')
            ->where('researchs.user_id', $id)
            ->where('conferences.status', 1)
            ->get()
            ->sortBy('id');

        $comments = Comment::select(
            'comments.topic_id as comment_topic_id',
            'comments.name as comment_name',
            'comments.path as comment_path',
            'comments.extension as comment_ext',
            'comments.created_at as comment_update'
        )
            ->leftjoin('researchs', 'researchs.topic_id', '=', 'comments.topic_id')
            ->where('researchs.user_id', $id)
            ->get();

        write_logs(__FUNCTION__, "info");

        DB::disconnect('conferences');
        DB::disconnect('researchs');
        DB::disconnect('comments');
        return view('frontend.pages.show_research', compact('data', 'comments', 'conference'));
    }

    public function edit($id)
    {
        $faculties = Faculty::get();
        $degrees = Degree::get();
        $branches = Branch::get();
        $presents = Present::get();
        $tips = Tip::where('group', '1')->get();
        $researchs = Research::where('topic_id', $id)->get();
        $conference_id = Conference::where('status_research', 1)->first();
        $this->authorize(
            'update',
            Research::select('user_id as id')->where('topic_id', $id)->first()
        );

        write_logs(__FUNCTION__, "info");

        $prefixs = [
            'นาย',
            'นาง',
            'นางสาว',
            'หม่อมเจ้า',
            'หม่อมราชวงศ์',
            'หม่อมหลวง',
            'หม่อม',
            'ท่านผู้หญิง',
            'คุณหญิง',
            'คุณ',
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
        DB::disconnect('tips');
        DB::disconnect('researchs');
        DB::disconnect('conferences');
        return view('frontend.pages.edit_research', compact('faculties', 'degrees', 'branches', 'presents', 'tips', 'researchs', 'conference_id', 'prefixs'));
    }


    protected function update(Request $request, $id)
    {
        $this->validator($request);
        $prefix_presenter = [];
        foreach ($request->presenters as $key => $presenter) {
            if ($presenter) {
                array_push($prefix_presenter, $request->prefixs[$key] . "!!" . $presenter);
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
        return redirect()->route('employee.research.show', auth()->user()->id)->with('success', true);
    }
}
