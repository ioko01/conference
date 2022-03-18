<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tip;
use App\Models\Slip;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $tips = Tip::where('group', '2')->get();
        return view('frontend.pages.payment', compact('tips'));
    }

    public function validation($request)
    {
        $validator = Validator::make($request->all(), [
            'payment_upload' => 'required|mimes:jpg,jpeg|max:10240',
            'date' => 'required',
            'address' => 'required'
        ]);
        return $validator;
    }

    public function file($request, $id)
    {
        $result = new Slip;
        $validator = $this->validation($request);
        if (!$validator->fails()) {
            $upload = $request->file('payment_upload');
            $extension = $upload->extension();
            $name = strval($id) . "." . $extension;
            $path = 'public/files/slips';

            $data = array_filter([
                'user_id' => auth()->user()->id,
                'topic_id' => $id,
                'name' => $name,
                'path' => $path . "/" . $name,
                'extension' => $extension,
                'address' => $request->address,
                'date' => $request->date,
                'conference_id' => auth()->user()->conference_id
            ]);

            $result->data = $data;
            $result->upload = $upload->storeAs($path, $name);
            $result->validate = $validator->fails();

            return $result;
        } else {
            $result->validate = $validator;
            return $result;
        }
    }

    public function store(Request $request, $id)
    {
        $slip = Slip::select('researchs.user_id as user_id')->rightjoin('researchs', 'researchs.topic_id', 'slips.topic_id')->where('researchs.topic_id', $id)->first();
        $this->authorize('update', $slip);
        if (!$this->file($request, $id)->validate) {
            Slip::create($this->file($request, $id)->data);
            $this->file($request, $id)->upload;

            alert('สำเร็จ', 'อัพโหลด SLIP สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'อัพโหลด SLIP สำเร็จ');
        } else {
            alert('ผิดพลาด', 'ไม่สามารถอัพโหลด SLIP ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('errors', 'ไม่สามารถอัพโหลด SLIP ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        if (!$this->file($request, $id)->validate) {
            Slip::where('topic_id', $id)->update($this->file($request, $id)->data);
            $this->file($request, $id)->upload;

            alert('สำเร็จ', 'แก้ไข SLIP สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('success', 'แก้ไข SLIP สำเร็จ');
        } else {
            alert('ผิดพลาด', 'ไม่สามารถอัพโหลด SLIP ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->with('errors', 'ไม่สามารถแก้ไข SLIP ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง')->withInput();
        }
    }
}
