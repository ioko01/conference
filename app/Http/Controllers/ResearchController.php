<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Research;

class ResearchController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('frontend.pages.send_research');
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
            'topicTH' => 'required',
            'topicEN' => 'required',
            'presenter1' => 'required',
            'group' => 'required',
            'group2' => 'required',
            'volResearch' => 'required',
            'presentTypes' => 'required',
            'personTypes' => 'required',
            ],[
                'topicTH.required' => 'กรุณากรอกชื่อบทความ (ภาษาไทย)',
                'topicEN.required' => 'กรุณากรอกชื่อบทความ (ภาษาอังกฤษ)',
            ]);
        
        Research::create([
            'user_id' => auth()->user()->id,
            'topic_id' => "1",
            'topic_th' => $request->topicTH,
            'topic_en' => $request->topicEN,
            'presenter' => $request->presenter1,
            'group' => $request->group,
            'group2' => $request->group2,
            'volumn' => $request->volResearch,
            'type' => $request->presentTypes,
            'person_type' => $request->personTypes,
        ]);
        
        return redirect()->route('employee.research.show', auth()->user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Research::where('user_id', $id)->get();
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