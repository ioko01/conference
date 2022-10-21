<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\ProceedingFile;
use App\Models\ProceedingTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProceedingFileController extends Controller
{
    public function index($year)
    {
        $files = ProceedingFile::select(
            'proceeding_files.id as id',
            'proceeding_files.name as name',
            'proceeding_files.link as link',
            'proceeding_files.path as path',
            'proceeding_topics.topic as topic',
            'proceeding_topics.position as position',
            'proceeding_files.extension as extension',
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_files.conference_id')
            ->leftjoin('proceeding_topics', 'proceeding_files.topic_id', 'proceeding_topics.id')
            ->where('conferences.year', $year)
            ->orderBy('proceeding_topics.position')
            ->get();

        $topics = ProceedingTopic::select(
            'proceeding_topics.id as id',
            'proceeding_topics.topic as topic',
            'proceeding_topics.position as position'
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_topics.conference_id')
            ->where('conferences.year', $year)
            ->orderBy('proceeding_topics.position')
            ->get();

        $i_topic = [];
        $i_topic[0] = null;
        $j = 0;

        foreach ($files as $key => $file) {
            if ($j == 0) {
                ++$j;
            }
            if ($j > 0) {
                if ($i_topic[$j - 1] != $file->topic) {
                    $i_topic[$j] = $file->topic;
                    $j++;
                }
            }
        }

        $conference = Conference::where('year', $year)->orderBy('id', 'DESC')->first();
        return view('backend.pages.proceeding_file', compact('year', 'files', 'topics', 'i_topic', 'conference'));
    }

    protected function validator($request)
    {
        alert('ผิดพลาด', 'มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');

        if ($request->download == "link") {
            return $request->validate([
                'topic_id' => 'required',
                'name' => 'required',
                'link_upload' => 'required'
            ]);
        } else if ($request->download == "file") {
            if ($request->name_file) {
                return $request->validate([
                    'topic_id' => 'required',
                    'name' => 'required',
                    'file_upload' => 'mimes:pdf,doc,docx,jpeg,jpg,png|max:10240'
                ]);
            } else {
                return $request->validate([
                    'topic_id' => 'required',
                    'name' => 'required',
                    'file_upload' => 'required|mimes:pdf,doc,docx,jpeg,jpg,png|max:10240'
                ]);
            }
        }
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
            $path = 'public/ประชุมวิชาการ ' . $year . '/proceeding (ห้ามลบ)';
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

    public function edit($year, $id)
    {
        $files = ProceedingFile::select(
            'proceeding_files.id as id',
            'proceeding_files.name as name',
            'proceeding_files.link as link',
            'proceeding_files.path as path',
            'proceeding_topics.topic as topic',
            'proceeding_topics.position as position',
            'proceeding_files.extension as extension',
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_files.conference_id')
            ->leftjoin('proceeding_topics', 'proceeding_files.topic_id', 'proceeding_topics.id')
            ->where('conferences.year', $year)
            ->orderBy('proceeding_topics.position')
            ->get();

        $_file = ProceedingFile::select(
            'proceeding_files.id as id',
            'proceeding_files.name as name',
            'proceeding_files.link as link',
            'proceeding_files.path as path',
            'proceeding_files.topic_id as topic_id',
            'proceeding_topics.topic as topic',
            'proceeding_topics.position as position',
            'proceeding_files.extension as extension',
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_files.conference_id')
            ->leftjoin('proceeding_topics', 'proceeding_files.topic_id', 'proceeding_topics.id')
            ->where('conferences.year', $year)
            ->where('proceeding_files.id', $id)
            ->orderBy('proceeding_topics.position')
            ->first();

        $topics = ProceedingTopic::select(
            'proceeding_topics.id as id',
            'proceeding_topics.topic as topic',
            'proceeding_topics.position as position'
        )
            ->leftjoin('conferences', 'conferences.id', 'proceeding_topics.conference_id')
            ->where('conferences.year', $year)
            ->orderBy('proceeding_topics.position')
            ->get();

        $i_topic = [];
        $i_topic[0] = null;
        $j = 0;

        foreach ($files as $key => $file) {
            if ($j == 0) {
                ++$j;
            }
            if ($j > 0) {
                if ($i_topic[$j - 1] != $file->topic) {
                    $i_topic[$j] = $file->topic;
                    $j++;
                }
            }
        }

        $conference = Conference::where('year', $year)->orderBy('id', 'DESC')->first();
        return view('backend.pages.edit_proceeding_file', compact('year', 'files', 'topics', 'i_topic', '_file', 'conference'));
    }

    protected function update(Request $request, $year, $id)
    {

        $this->validator($request);
        $conference = Conference::where('year', $year)->first();

        $path_file = ProceedingFile::find($id);

        $name_file = $path_file->name . "." . $path_file->extension;

        if ($request->download == "file") {
            if ($request->name_file != $name_file) {
                if (Storage::exists($path_file->path)) {
                    Storage::delete($path_file->path);
                }
            }
        } else if ($request->download == "link") {
            if (Storage::exists($path_file->path)) {
                Storage::delete($path_file->path);
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
            $path = 'public/ประชุมวิชาการ ' . $year . '/proceeding (ห้ามลบ)';
            $fullpath = $path . "/" . $name;
            $upload->storeAs($path, $name);
        }


        if ($request->download == "file") {
            if ($request->name_file) {
                if ($request->file('file_upload')) {
                    $data = [
                        'user_id' => auth()->user()->id,
                        'topic_id' => $request->topic_id,
                        'name' => $request->name,
                        'link' => $request->link_upload ? $request->link_upload : null,
                        'path' => $fullpath,
                        'extension' => $extension,
                        'conference_id' => $conference->id
                    ];
                } else {
                    $data = [
                        'user_id' => auth()->user()->id,
                        'topic_id' => $request->topic_id,
                        'name' => $request->name,
                        'conference_id' => $conference->id
                    ];
                }
            }
        } else if ($request->download == "link") {
            $data = [
                'user_id' => auth()->user()->id,
                'topic_id' => $request->topic_id,
                'name' => $request->name,
                'link' => $request->link_upload,
                'path' => null,
                'extension' => null,
                'conference_id' => $conference->id
            ];
        }

        ProceedingFile::where('id', $id)->update($data);
        alert('สำเร็จ', 'แก้ไขหัวข้อดาวน์โหลดไฟล์สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return back();
    }

    protected function destroy($year, $id)
    {

        $path_file = ProceedingFile::find($id);

        if (Storage::exists($path_file->path)) {
            Storage::delete($path_file->path);
        }

        ProceedingFile::leftjoin('conferences', 'conferences.id', 'proceeding_files.conference_id')
            ->where('proceeding_files.id', $id)
            ->where('conferences.year', $year)
            ->delete();

        alert('สำเร็จ', 'ลบหัวข้อสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');
        return redirect()->route('backend.proceeding.file.index', $year);
    }
}
