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
        $conference_id = Conference::where('status', 1)->first();

        return view('frontend.pages.send_research', compact('faculties', 'degrees', 'branches', 'presents', 'tips', 'conference_id'));
    }

    public function validator($request)
    {
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
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

    public function create(array $data)
    {
    }

    public function store(Request $request)
    {
        $this->validator($request);
        $presenters = join('|', array_filter($request->presenters));

        $topic_id = '65' . sprintf("%03d", Research::count() + 1);
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

        alert('สำเร็จ', 'เพิ่มบทความเรียบร้อย', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->route('employee.research.show', auth()->user()->id)->with('success', true);
    }

    public function show($id)
    {
        $research = Research::select('users.id as id')
            ->rightjoin('users', 'users.id', 'researchs.user_id')
            ->where('users.id', $id)
            ->first();
        $this->authorize('view', $research);
        $data = Research::select(
            'researchs.id as id',
            'researchs.topic_id as topic_id',
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
            'researchs.topic_status as status_id'
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
            ->where('researchs.user_id', $id)
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
        return view('frontend.pages.show_research', compact('data', 'comments'));
    }

    public function edit($id)
    {
        $faculties = Faculty::get();
        $degrees = Degree::get();
        $branches = Branch::get();
        $presents = Present::get();
        $tips = Tip::where('group', '1')->get();
        $researchs = Research::where('topic_id', $id)->get();

        $this->authorize(
            'update',
            Research::select('user_id as id')->where('topic_id', $id)->first()
        );
        return view('frontend.pages.edit_research', compact('faculties', 'degrees', 'branches', 'presents', 'tips', 'researchs'));
    }


    public function update(Request $request, $id)
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
        return redirect()->route('employee.research.show', auth()->user()->id)->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
