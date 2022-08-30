<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\ProceedingFile;
use App\Models\ProceedingTopic;
use Illuminate\Http\Request;

class ProceedingFileController extends Controller
{
    public function index($year)
    {
        $topics = ProceedingTopic::get();
        return view('backend.pages.proceeding_file', compact('year', 'topics'));
    }

    protected function validator($request)
    {
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        return $request->validate([
            'topic_id' => 'required',
            'name' => 'required'
        ]);
    }

    protected function store(Request $request, $year)
    {
        $this->validator($request);
        $conference = Conference::where('year', $year)->first();
        
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
            $path = 'public/conference_id_' . $conference->id . '/proceeding';
            $fullpath = $path . "/" . $name;
            $upload->storeAs($path, $name);
        }

        $data = array_filter([
            'user_id' => auth()->user()->id,
            'topic_id' => $request->topic_id,
            'name' => $request->name,
            'link' => $request->link_upload,
            'path' => $fullpath,
            'extension' => $extension,
            'conference_id' => $conference->id
        ]);

        ProceedingFile::create($data);

        alert('สำเร็จ', 'สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->back();
    }
}
