<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function index()
    {
        return view('backend.pages.download');
    }

    protected function validator($request)
    {
        alert('ผิดพลาด', 'กรุณาใส่หัวข้อนี้ดาวน์โหลดไฟล์', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate(
            [
                'name' => 'required',
                'file_upload' => 'max:10240'
            ]
        );
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
        $upload = '';
        $extension = '';
        $name = '';
        $path = '';
        $fullpath = '';
        if ($request->file('file_upload')) {
            $upload = $request->file('file_upload');
            $extension = $upload->extension();
            $name = "FILE_" . uniqid() . '.' . $extension;
            $path = 'public/assets/files';
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
}
