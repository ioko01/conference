<?php

namespace App\Http\Controllers\Backend;

use App\Exports\ExportUser;
use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Kota;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
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
            'users.created_at AS created_at',
            'users.updated_at AS updated_at',
            'conferences.status AS conference_status',
            'conferences.id AS conference'
        )
            ->leftjoin('conferences', 'users.conference_id', 'conferences.id')
            ->get();
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
            'institution' => $request['position_id'] == '2' ? 'required|string' : 'string',
            'address' => 'required',
            'position_id' => 'required',
            'person_attend' => 'required',
        ]);
    }

    protected function update(Request $request, $id)
    {

        $this->validator($request);

        if ($request->position_id == '1') {
            $institution = 'มหาวิทยาลัยราชภัฏเลย';
        } elseif ($request->position_id == '3') {
            if (isset($request->kota_id)) {
                $kota = Kota::find($request->kota_id);
                $institution = $kota->name;
            }
        } else {
            $institution = $request->institution;
        }

        User::where('id', $id)->update(
            [
                'prefix' => $request->prefix,
                'fullname' => $request->fullname,
                'sex' => $request->sex,
                'phone' => $request->phone,
                'institution' => $institution,
                'address' => $request->address,
                'check_requirement' => $request->receive_check,
                'position_id' => $request->position_id,
                'kota_id' => isset($request->kota_id) ? $request->kota_id : null,
                'person_attend' => $request->person_attend,
                'is_admin' => isset($request->is_admin)  ? $request->is_admin : auth()->user()->is_admin
            ]
        );

        alert('สำเร็จ', 'แก้ไขผู้ใช้งานสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back()->with('success', 'แก้ไขผู้ใช้งานสำเร็จ');
    }

    protected function export()
    {
        return Excel::download(new ExportUser, 'EXPORT_USERS.xlsx');
    }
}
