<?php

namespace App\Http\Controllers\Backend;

use App\Exports\ExportUser;
use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Kota;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select(
            'users.id AS id',
            'users.conference_id AS conference_id',
            'users.prefix AS prefix',
            'users.fullname AS fullname',
            'users.sex AS sex',
            'users.phone AS phone',
            'users.institution AS institution',
            'users.address AS address',
            'users.check_requirement AS check_requirement',
            'users.position_id AS position_id',
            'users.kota_id AS kota_id',
            'users.person_attend AS person_attend',
            'users.email AS email',
            'users.email_verified_at AS email_verified',
            'users.created_at AS created_at',
            'users.updated_at AS updated_at',
            'conferences.status AS conference_status',
            'conferences.id AS conference'
        )
            ->leftjoin('conferences', 'users.conference_id', 'conferences.id')
            ->get();

        DB::disconnect('users');
        return view('backend.pages.user', compact('users'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $positions = Position::get();
        $kotas = Kota::get();
        write_logs(__FUNCTION__, "info");

        DB::disconnect('users');
        DB::disconnect('positions');
        DB::disconnect('kotas');
        return view('backend.pages.edit_user', compact('user', 'positions', 'kotas'));
    }

    protected function validator($request)
    {
        write_logs(__FUNCTION__, "error");
        if ($request->person_attend == "attend") {
            return $request->validate([
                'prefix' => 'required|string',
                'fullname' => 'required|string',
                'sex' => 'required',
                'phone' => 'required|string|max:10',
                'institution' => $request->position_id == '2' ? 'required|string' : 'string',
                'position_id' => 'required',
                'person_attend' => 'required',
            ]);
        } else if ($request->person_attend == "send") {
            if ($request->position_id == '2') {
                return $request->validate([
                    'prefix' => 'required|string',
                    'fullname' => 'required|string',
                    'sex' => 'required',
                    'phone' => 'required|string|max:10',
                    'institution' => $request->position_id == '2' ? 'required|string' : 'string',
                    'address' => 'required|string',
                    'position_id' => 'required',
                    'person_attend' => 'required',
                    'receive_check' => 'required'
                ]);
            } else {
                return $request->validate([
                    'prefix' => 'required|string',
                    'fullname' => 'required|string',
                    'sex' => 'required',
                    'phone' => 'required|string|max:10',
                    'institution' => $request->position_id == '2' ? 'required|string' : 'string',
                    'position_id' => 'required',
                    'person_attend' => 'required'
                ]);
            }
        }
    }

    protected function update(Request $request, $id)
    {
        $this->validator($request);

        if ($request->position_id == '1') {
            $institution = 'มหาวิทยาลัยราชภัฏเลย';
            $check_requirement = null;
            $address = null;
        } else if ($request->position_id == '3') {
            if (isset($request->kota_id)) {
                $kota = Kota::find($request->kota_id);
                $institution = $kota->name;
            }
            $check_requirement = null;
            $address = null;
        } else {
            $institution = $request->institution;
            $check_requirement = $request->receive_check;
            $address = $request->address;
        }

        if ($request->person_attend == "attend") {
            $check_requirement = null;
        }


        User::where('id', $id)->update(
            [
                'prefix' => $request->prefix,
                'fullname' => $request->fullname,
                'sex' => $request->sex,
                'phone' => $request->phone,
                'institution' => $institution,
                'address' => $address,
                'check_requirement' => $check_requirement,
                'position_id' => $request->position_id,
                'kota_id' => isset($request->kota_id) ? $request->kota_id : null,
                'person_attend' => $request->person_attend,
                'is_admin' => isset($request->is_admin)  ? $request->is_admin : auth()->user()->is_admin
            ]
        );
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไขผู้ใช้งานสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('kotas');
        DB::disconnect('users');
        return back()->with('success', 'แก้ไขผู้ใช้งานสำเร็จ');
    }

    protected function export()
    {
        write_logs(__FUNCTION__, "info");
        $date = date("d_m_Y");
        return Excel::download(new ExportUser, "EXPORT_USERS_$date.xlsx");
    }

    public function change_password($id)
    {
        write_logs(__FUNCTION__, "info");
        $user = User::where('id', $id)->first();

        DB::disconnect('users');
        return view('backend.pages.change_password', compact('id', 'user'));
    }

    protected function update_password(Request $request, $id)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = User::where('id', $id)->first();

        #Match The Old Password
        if (!Hash::check($request->old_password, $user->password)) {
            write_logs(__FUNCTION__, "error");
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::where('id', $id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'เปลี่ยนรหัสผ่านสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('users');
        return back()->with("status", "เปลี่ยนรหัสผ่านสำเร็จ");
    }
}
