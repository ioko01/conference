<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\Conference;
use App\Models\Kota;
use App\Models\Position;
use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterAttendController extends Controller
{
    protected function validator($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'ไม่สามารถลงทะเบียนเข้าร่วมงานได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'prefix' => 'required|string',
            'fullname' => 'required|string',
            'sex' => 'required',
            'phone' => 'required|string|max:10',
            'institution' => $request->position_id == '2' ? 'required|string' : 'string',
            'position_id' => 'required',
            'email' => 'required|string|email|unique:attends',
        ]);
    }

    public function index()
    {
        $kotas = Kota::get();
        $positions = Position::get();
        $conference_id = Conference::where('status_research', 1)->first();
        $tips = Tip::where('group', '1')->get();


        DB::disconnect('kotas');
        DB::disconnect('positions');
        DB::disconnect('conferences');
        DB::disconnect('tips');
        return view('frontend.pages.register_attend', compact('kotas', 'positions', 'conference_id', 'tips'));
    }

    public function store(Request $request)
    {
        $conference_id = Conference::where('status', 1)->first();

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

        Attend::create([
            'prefix' => $request->prefix,
            'fullname' => $request->fullname,
            'sex' => $request->sex,
            'phone' => $request->phone,
            'institution' => $institution,
            'position_id' => $request->position_id,
            'kota_id' => isset($request->kota_id) ? $request->kota_id : null,
            'email' => $request->email,
            'conference_id' => isset($conference_id->id) ? $conference_id->id : null,
            'person_attend' => "attend"
        ]);

        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'ลงทะเบียนเข้าร่วมงานสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('conferences');
        DB::disconnect('kotas');
        return redirect()->route('welcome');
    }
}
