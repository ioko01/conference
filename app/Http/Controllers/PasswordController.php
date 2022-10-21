<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    //
    public function change_password()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('frontend.pages.change_password', compact('user'));
    }

    public function update_password(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('id', auth()->user()->id)->first();

        #Match The Old Password
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with("error", "รหัสผ่านไม่ตรงกัน");
        }


        #Update the new Password
        User::where('id', auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        alert('สำเร็จ', 'เปลี่ยนรหัสผ่านสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with("status", "เปลี่ยนรหัสผ่านสำเร็จ");
    }
}
