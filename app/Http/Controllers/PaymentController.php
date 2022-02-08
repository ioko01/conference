<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tip;
use App\Models\Slip;

class PaymentController extends Controller
{
    //
    public function index(){
        $tips = Tip::where('group', '2')->get();
        return view('frontend.pages.payment', compact('tips'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $request->validate([
                'payment_upload' => 'required|mimes:jpg,jpeg|max:10240',
                'date' => 'required',
                'address' => 'required'
            ]
        );
        
        if($request->file('payment_upload')){
            $upload = $request->file('payment_upload');
            $extension = $upload->extension();
            $name = strval($id).".".$extension;
            $path = 'public/files/slips';
        }

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path."/".$name,
            'extension' => $extension,
            'address' => $request->address,
            'date' => $request->date
        ]);

        $slip = Slip::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'slips.topic_id')->where('researchs.topic_id', $id)->first();
        
        $this->authorize('update', $slip);    
        Slip::create($data);

        $upload->storeAs($path, $name);

        return back()->with('success', true);
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
        
        $request->validate([
                'payment_upload' => 'required|mimes:jpg,jpeg|max:10240',
                'date' => 'required',
                'address' => 'required'
            ]
        );

        $path = null;
        $extension = null;
        
        if($request->file('payment_upload')){
            $upload = $request->file('payment_upload');
            $extension = $upload->extension();
            $name = strval($id).".".$extension;
            $path = 'public/files/slips';
            
        }

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path."/".$name,
            'extension' => $extension,
            'address' => $request->address,
            'date' => $request->date
        ]);

        Slip::where('topic_id', $id)->update($data);
        $upload->storeAs($path, $name);
        return back()->with('success', true);
    }
}