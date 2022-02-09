<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tip;
use App\Models\Slip;

class PaymentController extends Controller
{
    public function index(){
        $tips = Tip::where('group', '2')->get();
        return view('frontend.pages.payment', compact('tips'));
    }

    public function validation($request){
        $request->validate([
                'payment_upload' => 'required|mimes:jpg,jpeg|max:10240',
                'date' => 'required',
                'address' => 'required'
            ]
        );

        return $request;
    }

    public function file($request, $id){
        $result = new Slip;
        $this->validation($request);

        $upload = $request->file('payment_upload');
        $extension = $upload->extension();
        $name = strval($id).".".$extension;
        $path = 'public/files/slips';

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $id,
            'name' => $name,
            'path' => $path."/".$name,
            'extension' => $extension,
            'address' => $request->address,
            'date' => $request->date
        ]);

        $result->data = $data;
        $result->upload = $upload->storeAs($path, $name);
        
        return $result;
    }

    public function store(Request $request, $id)
    {
        $slip = Slip::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'slips.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $slip);    

        Slip::create($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }

     public function update(Request $request, $id)
    { 
        Slip::where('topic_id', $id)->update($this->file($request, $id)->data);
        $this->file($request, $id)->upload;

        return back()->with('success', true);
    }
}