<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LineController extends Controller
{
    //
    public function index()
    {
        $conferences = Conference::where('status', 1)->get();
        $lines = Line::select(
            'lines.id as id',
            'conferences.name as conference_name',
            'lines.link as line_link',
            'lines.name as line_name',
            'lines.path as line_path',
            'lines.extension as line_extension'
        )
            ->leftjoin('conferences', 'conferences.id', 'lines.conference_id')
            ->get();

        foreach ($lines as $line) {
            $line->line_path = Storage::url($line->line_path);
        }

        DB::disconnect('conferences');
        DB::disconnect('lines');
        return view('backend.pages.line', compact('conferences', 'lines'));
    }

    protected function validator($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'ไม่สามารถเพิ่ม Line Openchat ได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'conference_name' => 'required',
            'file' => 'mimes:jpg,jpeg,png|max:10240'
        ]);
    }

    protected function store(Request $request)
    {
        $conference = Conference::where('status', 1)->first();
        if (isset($conference->id)) {
            $upload = null;
            $extension = null;
            $name = null;
            $path = null;
            $full_path = null;

            $this->validator($request);

            $conference_year = Conference::where('id', auth()->user()->conference_id)->first();
            if ($request->hasFile('file')) {
                $upload = $request->file('file');
                $extension = $upload->extension();
                $name = "QR_OPENCHAT_" . $conference_year->year . "." . $extension;
                $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/line_openchat';
                $full_path = $path . "/" . $name;

                $upload->storeAs($path, $name);
            }

            $data = array_filter([
                'conference_id' => auth()->user()->conference_id,
                'user_id' => auth()->user()->id,
                'name' => $name,
                'link' => $request->link,
                'path' => $full_path,
                'extension' => $extension
            ]);

            $conference = Line::select('conference_id')->where('conference_id', auth()->user()->conference_id)->first();
            if (isset($conference->conference_id)) {
                if ($conference->conference_id == auth()->user()->conference_id) {
                    write_logs(__FUNCTION__, "info");
                    alert('ผิดพลาด', 'ไม่สามารถเพิ่ม Line Openchat ในการประชุมครั้งนี้ได้อีก', 'error')->showConfirmButton('ปิด', '#3085d6');

                    DB::disconnect('conferences');
                    DB::disconnect('lines');
                    return back()->withErrors('ไม่สามารถเพิ่ม Line Openchat ในการประชุมครั้งนี้ได้อีก');
                }
            }

            Line::create($data);
            write_logs(__FUNCTION__, "info");
            alert('สำเร็จ', 'เพิ่ม Line Openchat สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

            DB::disconnect('conferences');
            DB::disconnect('lines');
            return back()->with('success', true);
        } else {
            write_logs(__FUNCTION__, "error");
            alert('ผิดพลาด', 'ไม่มีการประชุมที่เปิดใช้งาน', 'error')->showConfirmButton('ปิด', '#3085d6');

            DB::disconnect('conferences');
            return back()->withErrors('ไม่มีการประชุมที่เปิดใช้งาน');
        }
    }

    protected function edit($id)
    {
        $conferences = Conference::where('status', 1)->get();

        $lines = Line::select(
            'lines.id as id',
            'conferences.name as conference_name',
            'lines.link as line_link',
            'lines.name as line_name',
            'lines.path as line_path',
            'lines.extension as line_extension'
        )
            ->leftjoin('conferences', 'conferences.id', 'lines.conference_id')
            ->get();
        foreach ($lines as $line) {
            $line->line_path = Storage::url($line->line_path);
        }

        $line = Line::select(
            'lines.id as id',
            'conferences.name as conference_name',
            'lines.link as line_link',
            'lines.name as line_name',
            'lines.path as line_path',
            'lines.extension as line_extension'
        )
            ->leftjoin('conferences', 'conferences.id', 'lines.conference_id')
            ->find($id);

        write_logs(__FUNCTION__, "info");

        DB::disconnect('conferences');
        DB::disconnect('lines');
        return view('backend.pages.edit_line', compact('conferences', 'lines', 'line'));
    }

    protected function update(Request $request, $id)
    {
        if (!auth()->user()->conference_id) {
            write_logs(__FUNCTION__, "error");
            alert('ผิดพลาด', 'ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->withErrors('ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้');
        }

        $line = Line::find($id);
        $this->validator($request);


        if ($request->name_file != $line->name) {
            if (Storage::exists($line->path)) {
                write_logs(__FUNCTION__, "warning");
                Storage::delete($line->path);
            }
        }

        $conference_year = Conference::where('id', auth()->user()->conference_id)->first();

        $upload = null;
        $extension = null;
        $name = null;
        $path = null;
        $fullpath = null;
        if ($request->hasFile('file')) {
            $upload = $request->file('file');
            $extension = $upload->extension();
            $name = "QR_OPENCHAT_" . auth()->user()->conference_id . "." . $extension;
            $path = 'public/ประชุมวิชาการ ' . $conference_year->year . '/line_openchat';
            $fullpath = $path . "/" . $name;

            $upload->storeAs($path, $name);
        }

        if ($request->hasFile('file')) {
            $data = [
                'user_id' => auth()->user()->id,
                'link' => $request->link,
                'name' => $name,
                'path' => $fullpath,
                'extension' => $extension,
                'conference_id' => auth()->user()->conference_id
            ];
        } else {
            $data = [
                'user_id' => auth()->user()->id,
                'link' => $request->link,
                'conference_id' => auth()->user()->conference_id
            ];
        }

        Line::where('id', $id)->update($data);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไข Line Open Chat สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        
        DB::disconnect('conferences');
        DB::disconnect('lines');
        return back();
    }

    public function destroy($id)
    {
        $line = Line::find($id);
        if (Storage::exists($line->path)) {
            Storage::delete($line->path);
        }
        Line::where('id', $id)->delete();
        write_logs(__FUNCTION__, "warning");
        alert('สำเร็จ', 'ลบหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        
        DB::disconnect('lines');
        return redirect()->route('backend.lines.index');
    }
}
