<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::leftjoin('conferences', 'conferences.id', 'downloads.conference_id')
            ->where('conferences.status', 1)
            ->get();
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
        $conference = Conference::where('id', auth()->user()->conference_id)->first();
        if (!isset($conference->id)) {
            alert('ผิดพลาด', 'ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->withErrors('ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้');
        }

        $downloads = Download::leftjoin('conferences', 'conferences.id', 'downloads.conference_id')
            ->where('conferences.status', 1)
            ->get();
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
        if ($request->hasFile('file_upload')) {
            $upload = $request->file('file_upload');
            $extension = $upload->extension();
            $file_name = $request->name;
            $name = $file_name . '.' . $extension;
            $path = 'public/conference_' . auth()->user()->conference_id . '/ไฟล์/ดาวน์โหลด';
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
        return redirect()->route('backend.downloads.index');
    }

    protected function edit($id)
    {
        $downloads = Download::leftjoin('conferences', 'conferences.id', 'downloads.conference_id')
            ->where('conferences.status', 1)
            ->get();
        $download = Download::find($id);
        return view('backend.pages.edit_download', compact('downloads', 'download', 'id'));
    }

    protected function update(Request $request, $id)
    {
        $conference = Conference::where('id', auth()->user()->conference_id)->first();
        if (!isset($conference->id)) {
            alert('ผิดพลาด', 'ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้', 'error')->showConfirmButton('ปิด', '#3085d6');
            return back()->withErrors('ต้องเปิดใช้งานหัวข้อการประชุมก่อนถึงจะเพิ่มหัวข้อดาวน์โหลดได้');
        }

        $download = Download::find($id);
        $downloads = Download::leftjoin('conferences', 'conferences.id', 'downloads.conference_id')
            ->where('conferences.status', 1)
            ->get();
        $this->validator($request);

        foreach ($downloads as $down) {
            if ($down->name == $request->name && auth()->user()->conference_id == $down->conference_id && $down->user_id != auth()->user()->id) {
                alert('ผิดพลาด', 'มีหัวข้อนี้ดาวน์โหลดไฟล์นี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้', 'error')->showConfirmButton('ปิด', '#3085d6');
                return back()->withErrors('มีหัวข้อนี้ดาวน์โหลดไฟล์นี้แล้ว ไม่สามารถเพิ่มหัวข้อที่มีชื่อเดียวกันได้');
            }
        }

        if ($request->download == "file") {
            if ($request->name_file != $download->name_file) {
                if (Storage::exists($download->path_file)) {
                    Storage::delete($download->path_file);
                }
            }
        } else if ($request->download == "link") {
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
            $path = 'public/conference_' . auth()->user()->conference_id . '/ไฟล์/ดาวน์โหลด';
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
        return redirect()->route('backend.downloads.index');
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
        Download::where('id', $id)->update($data);
        alert('สำเร็จ', 'นำขึ้นประชาสัมพันธ์สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back();
    }
}
