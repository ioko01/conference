<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManualController extends Controller
{
    public function index()
    {
        $manuals = Manual::get();

        DB::disconnect('manuals');
        return view('backend.pages.manual', compact('manuals'));
    }

    protected function validator($request)
    {
        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        if ($request->download == "link") {
            return $request->validate(
                [
                    'name' => 'required',
                    'link_upload' => 'required',
                    'file_upload' => 'mimes:pdf,pptx,docx,doc,jpg,jpeg,png|max:10240'
                ]
            );
        } else if ($request->download == "file") {
            if ($request->name_file) {
                return $request->validate(
                    [
                        'name' => 'required',
                        'file_upload' => 'max:10240'
                    ]
                );
            } else {
                return $request->validate(
                    [
                        'name' => 'required',
                        'file_upload' => 'required|max:10240'
                    ]
                );
            }
        }
    }

    protected function store(Request $request)
    {
        $conference = Conference::where('id', auth()->user()->conference_id)->first();
        if (!isset($conference->id)) {
            write_logs(__FUNCTION__, "error");
            alert('ผิดพลาด', 'ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อได้', 'error')->showConfirmButton('ปิด', '#3085d6');

            DB::disconnect('conferences');
            return back()->withErrors('ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อได้');
        }

        $manuals = Manual::get();
        $this->validator($request);

        foreach ($manuals as $manual) {
            if ($manual->name == $request->name && auth()->user()->conference_id == $manual->conference_id) {
                write_logs(__FUNCTION__, "error");
                alert('ผิดพลาด', 'มีหัวข้อนี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้', 'error')->showConfirmButton('ปิด', '#3085d6');

                DB::disconnect('manuals');
                return back()->withErrors('มีหัวข้อนี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้');
            }
        }



        $upload = null;
        $extension = null;
        $name = null;
        $path = null;
        $fullpath = null;
        if ($request->file('file_upload')) {
            $upload = $request->file('file_upload');
            $extension = $upload->extension();
            $file_name = $request->name;
            $name = $file_name . '.' . $extension;
            $path = 'public/ประชุมวิชาการ ' . $conference->year . '/ไฟล์/คู่มือ';
            $fullpath = $path . "/" . $name;
            $upload->storeAs($path, $name);
        }

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'link' => $request->link_upload,
            'name_file' => $name,
            'path_file' => $fullpath,
            'ext_file' => $extension,
            'conference_id' => auth()->user()->conference_id
        ]);

        Manual::create($data);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'เพิ่มหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('manuals');
        return redirect()->route('backend.manuals.index');
    }

    protected function edit($id)
    {
        $manuals = Manual::get();
        $manual = Manual::find($id);
        write_logs(__FUNCTION__, "info");

        DB::disconnect('manuals');
        return view('backend.pages.edit_manual', compact('manuals', 'manual', 'id'));
    }

    protected function update(Request $request, $id)
    {
        $conference = Conference::where('id', auth()->user()->conference_id)->first();
        if (!isset($conference->id)) {
            write_logs(__FUNCTION__, "error");
            alert('ผิดพลาด', 'ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อได้', 'error')->showConfirmButton('ปิด', '#3085d6');

            DB::disconnect('conferences');
            return back()->withErrors('ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อได้');
        }

        $manual = Manual::find($id);
        $manuals = Manual::get();
        $this->validator($request);

        foreach ($manuals as $man) {
            if ($man->name == $request->name && auth()->user()->conference_id == $man->conference_id && $man->user_id != auth()->user()->id) {
                write_logs(__FUNCTION__, "error");
                alert('ผิดพลาด', 'มีหัวข้อนี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้', 'error')->showConfirmButton('ปิด', '#3085d6');

                DB::disconnect('manuals');
                return back()->withErrors('มีหัวข้อนี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้');
            }
        }

        if ($request->download == "file") {
            if ($request->name_file != $manual->name_file) {
                if (Storage::exists($manual->path_file)) {
                    write_logs(__FUNCTION__, "warning");
                    Storage::delete($manual->path_file);
                }
            }
        } else if ($request->download == "link") {
            if (Storage::exists($manual->path_file)) {
                write_logs(__FUNCTION__, "warning");
                Storage::delete($manual->path_file);
            }
        }

        $upload = null;
        $extension = null;
        $name = null;
        $path = null;
        $fullpath = null;
        if ($request->file('file_upload')) {
            $upload = $request->file('file_upload');
            $extension = $upload->extension();
            $file_name = $request->name;
            $name = $file_name . '.' . $extension;
            $path = 'public/ประชุมวิชาการ ' . $conference->year . '/ไฟล์/คู่มือ';
            $fullpath = $path . "/" . $name;
            $upload->storeAs($path, $name);
        }


        if ($request->download == "file") {
            if ($request->name_file) {
                if ($request->file('file_upload')) {
                    $data = [
                        'user_id' => auth()->user()->id,
                        'name' => $request->name,
                        'link' => $request->link_upload ? $request->link_upload : null,
                        'name_file' => $name,
                        'path_file' => $fullpath,
                        'ext_file' => $extension,
                        'conference_id' => auth()->user()->conference_id
                    ];
                } else {
                    $data = [
                        'user_id' => auth()->user()->id,
                        'name' => $request->name,
                        'conference_id' => auth()->user()->conference_id
                    ];
                }
            }
        } else if ($request->download == "link") {
            $data = [
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'link' => $request->link_upload,
                'name_file' => null,
                'path_file' => null,
                'ext_file' => null,
                'conference_id' => auth()->user()->conference_id
            ];
        }

        Manual::where('id', $id)->update($data);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'แก้ไขหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('conferences');
        DB::disconnect('manuals');
        return back();
    }

    public function destroy($id)
    {
        $manual = Manual::find($id);
        if (Storage::exists($manual->path_file)) {
            Storage::delete($manual->path_file);
        }
        Manual::where('id', $id)->delete();
        write_logs(__FUNCTION__, "warning");
        alert('สำเร็จ', 'ลบหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('manuals');
        return redirect()->route('backend.manuals.index');
    }

    protected function notice(Request $request, $id)
    {
        $status = 0;
        if (!$request->notice) {
            $status = 1;
        }
        $data = [
            'user_id' => auth()->user()->id,
            'notice' => $status
        ];
        Manual::where('id', $id)->update($data);
        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'นำขึ้นประชาสัมพันธ์สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        
        DB::disconnect('manuals');
        return back();
    }
}
