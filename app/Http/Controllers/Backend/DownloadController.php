<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::get();
        return view('backend.pages.download', compact('downloads'));
    }

    protected function validator($request)
    {
        alert('ผิดพลาด', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        if ($request->download == "link") {
            return $request->validate(
                [
                    'name' => 'required',
                    'link_upload' => 'required',
                    'file_upload' => 'max:10240'
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
        if (!auth()->user()->conference_id) {
            alert('ผิดพลาด', 'ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->withErrors('ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้');
        }

        $downloads = Download::get();
        $this->validator($request);

        foreach ($downloads as $download) {
            if ($download->name == $request->name && auth()->user()->conference_id == $download->conference_id) {
                alert('ผิดพลาด', 'มีหัวข้อนี้ดาวน์โหลดไฟล์นี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้', 'error')->showConfirmButton('ปิด', '#3085d6');
                return back()->withErrors('มีหัวข้อนี้ดาวน์โหลดไฟล์นี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้');
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
            $path = 'public/assets/files/conference_id_' . auth()->user()->conference_id;
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

        Download::create($data);
        alert('สำเร็จ', 'เพิ่มหัวข้อดาวน์โหลดไฟล์สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->route('backend.download.index');
    }

    protected function edit($id)
    {
        $downloads = Download::get();
        $download = Download::find($id);
        return view('backend.pages.edit_download', compact('downloads', 'download', 'id'));
    }

    protected function update(Request $request, $id)
    {
        if (!auth()->user()->conference_id) {
            alert('ผิดพลาด', 'ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->withErrors('ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้');
        }

        $download = Download::find($id);
        $downloads = Download::get();
        $this->validator($request);

        foreach ($downloads as $download) {
            if ($download->name == $request->name && auth()->user()->conference_id == $download->conference_id && $download->user_id != auth()->user()->id) {
                alert('ผิดพลาด', 'มีหัวข้อนี้ดาวน์โหลดไฟล์นี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้', 'error')->showConfirmButton('ปิด', '#3085d6');
                return back()->withErrors('มีหัวข้อนี้ดาวน์โหลดไฟล์นี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้');
            }
        }

        if ($download->name_file != $request->name_file) {
            if (Storage::exists($download->path_file)) {
                Storage::delete($download->path_file);
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
            $path = 'public/assets/files/conference_id_' . auth()->user()->conference_id;
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

        Download::where('id', $id)->update($data);
        alert('สำเร็จ', 'แก้ไขหัวข้อดาวน์โหลดไฟล์สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back();
    }

    public function destroy($id)
    {
        $download = Download::find($id);
        if (Storage::exists($download->path_file)) {
            Storage::delete($download->path_file);
        }
        Download::where('id', $id)->delete();
        alert('สำเร็จ', 'ลบหัวข้อดาวน์โหลดไฟล์สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back();
    }
}
