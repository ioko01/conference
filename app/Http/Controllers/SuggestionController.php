<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Research;
use App\Models\SendSuggestionResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuggestionController extends Controller
{
    protected function validation($request)
    {
        alert('ผิดพลาด', 'ไม่สามารถอัพโหลดไฟล์ข้อเสนอแนะได้กรุณาตรวจสอบความถูกต้องอีกครั้ง', 'error')->showConfirmButton('ปิด', '#3085d6');
        write_logs(__FUNCTION__, "error");
        return $request->validate(['suggestion_upload' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240']);
    }

    protected function file($request, $link = null)
    {
        $decode_id = base64_decode($link);
        $spilt_id = explode("|", $decode_id);
        $number = $spilt_id[0];
        $topic_id = $spilt_id[1];

        $conference = Conference::where('status', 1)->first();
        $research = Research::where('topic_id', $topic_id)->first();
        $result = new SendSuggestionResearch;
        $suggestion = SendSuggestionResearch::select(DB::raw('COUNT(topic_id) as count_topic_id'))->where('number', $number)->where('topic_id', $topic_id)->first();
        $this->validation($request);
        $upload = $request->file('suggestion_upload');
        $extension = $upload->extension();

        $count = 1;
        if ($suggestion->count_topic_id > 0) {
            $count = $suggestion->count_topic_id + 1;
        }

        $name = 'ข้อเสนอ_' . strval($research->topic_id) . "_" . strval($number) . "_" . $count . "." . $extension;
        $path = 'public/ประชุมวิชาการ ' . $conference->year . '/ข้อเสนอแนะจากผู้ทรง';

        $data = array_filter([
            'user_id' => $research->user_id,
            'topic_id' => $research->topic_id,
            'number' => $number,
            'name' => $name,
            'path' => $path . "/" . $name,
            'extension' => $extension,
            'conference_id' => $research->conference_id
        ]);

        $result->data = $data;
        $result->upload = $upload->storeAs($path, $name);
        write_logs(__FUNCTION__, "info");

        DB::disconnect('conferences');
        DB::disconnect('researchs');
        DB::disconnect('send_suggestion_researchs');
        return $result;
    }

    public function index($link)
    {
        $conference = Conference::where('status', 1)->first();
        $decode_id = base64_decode($link);
        $spilt_id = explode("|", $decode_id);
        $number = $spilt_id[0];
        $topic_id = $spilt_id[1];

        $research = Research::where('topic_id', $topic_id)
            ->where('researchs.conference_id', $conference->id)
            ->first();

        $suggestions = SendSuggestionResearch::where('number', $number)
            ->where('topic_id', $topic_id)
            ->get();

        if (!$research) {
            abort(404);
        } else if ($research->created_at != $spilt_id[2]) {
            abort(404);
        }

        DB::disconnect('conferences');
        DB::disconnect('researchs');
        return view('frontend.pages.suggestion', compact('conference', 'research', 'suggestions'));
    }

    protected function store(Request $request, $link)
    {
        SendSuggestionResearch::create($this->file($request, $link)->data);


        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'อัพโหลดข้อเสนอแนะสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('send_suggestion_researchs');
        return back()->with('success', 'อัพโหลดข้อเสนอแนะสำเร็จ');
    }

    protected function destroy($link, $id)
    {
        $_file = SendSuggestionResearch::find($id);
        $topic_id = explode('|', base64_decode($link))[1];
        $_research = Research::where('topic_id', $topic_id)->first();

        if($topic_id != $_research->topic_id){
            abort(401);
        }

        if (Storage::exists($_file->path)) {
            Storage::delete($_file->path);
        }
        SendSuggestionResearch::where('id', $id)->delete();
        write_logs(__FUNCTION__, "warning");
        alert('สำเร็จ', 'ลบไฟล์สำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('send_suggestion_researchs');
        DB::disconnect('researchs');
        return redirect()->back();
    }
}
