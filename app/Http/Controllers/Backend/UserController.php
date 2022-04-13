<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('backend.pages.user', compact('users'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $positions = Position::get();
        $kotas = Kota::get();
        return view('backend.pages.edit_user', compact('user', 'positions', 'kotas'));
    }

    protected function validator($request)
    {
        return $request->validate([
            'prefix' => 'required',
            'fullname' => 'required',
            'sex' => 'required',
            'phone' => 'required|string|max:10',
            'institution' => 'required',
            'address' => 'required',
            'position_id' => 'required',
            'person_attend' => 'required',
        ]);
    }

    protected function update(Request $request, $id)
    {

        $this->validator($request);
        User::where('id', $id)->update(
            [
                'prefix' => $request->prefix,
                'fullname' => $request->fullname,
                'sex' => $request->sex,
                'phone' => $request->phone,
                'institution' => $request->institution,
                'address' => $request->address,
                'position_id' => $request->position_id,
                'kota_id' => isset($request->kota_id) ? $request->kota_id : null,
                'person_attend' => $request->person_attend,
                'is_admin' => isset($request->is_admin)  ? $request->is_admin : auth()->user()->is_admin
            ]
        );

        alert('สำเร็จ', 'แก้ไขผู้ใช้งานสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขผู้ใช้งานสำเร็จ');
    }
}
