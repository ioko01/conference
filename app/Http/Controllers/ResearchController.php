<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\Faculty;
use App\Models\Degree;
use App\Models\Branch;
use App\Models\Present;
use App\Models\Tip;

class ResearchController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties = Faculty::get();
        $degrees = Degree::get();
        $branches = Branch::get();
        $presents = Present::get();
        $tips = Tip::where('group', '1')->get();
        return view('frontend.pages.send_research', compact('faculties', 'degrees', 'branches', 'presents', 'tips'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(array $data)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'topic_th' => 'required',
            'topic_en' => 'required',
            'presenters.0' => 'required',
            'faculty_id' => 'required',
            'branch_id' => 'required',
            'degree_id' => 'required',
            'present_id' => 'required',
            ]);
        
        $presenters = join(',', array_filter($request->presenters));
        
        $topic_id = '65'.sprintf("%03d",Research::count()+1);
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
        ]);
        
        return redirect()->route('employee.research.show', auth()->user()->id)->with('success', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Research::
                        select('topic_id', 'topic_th', 'topic_en', 'presenter', 'faculties.name as faculty', 
                        'branches.name as branch', 'degrees.name as degree', 'presents.name as present', 
                        'users.phone as phone', 'users.institution as institution', 'users.address as address', 
                        'users.email as email', 'users.person_attend as attend', 'kotas.name as kota')
                        ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
                        ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
                        ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
                        ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
                        ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
                        ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
                        ->where('user_id', $id)
                        ->get();
        return view('frontend.pages.show_research', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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