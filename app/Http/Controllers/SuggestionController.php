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

    // protected function file($request, $link = null)
    // {
    //     $decode_id = base64_decode($link);
    //     $spilt_id = explode("|", $decode_id);
    //     $number = $spilt_id[0];
    //     $topic_id = $spilt_id[1];

    //     $conference = Conference::where('status', 1)->first();
    //     $research = Research::where('topic_id', $topic_id)->first();
    //     $result = new SendSuggestionResearch;
    //     $suggestion = SendSuggestionResearch::select(DB::raw('COUNT(topic_id) as count_topic_id'))->where('number', $number)->where('topic_id', $topic_id)->first();
    //     $this->validation($request);
    //     $upload = $request->file('suggestion_upload');
    //     $extension = $upload->extension();

    //     $count = 1;
    //     if ($suggestion->count_topic_id > 0) {
    //         $count = $suggestion->count_topic_id + 1;
    //     }

    //     $name = 'ข้อเสนอ_' . strval($research->topic_id) . "_" . strval($number) . "_" . $count . "." . $extension;
    //     $path = 'public/ประชุมวิชาการ ' . $conference->year . '/ข้อเสนอแนะจากผู้ทรง';

    //     $data = array_filter([
    //         'user_id' => $research->user_id,
    //         'topic_id' => $research->topic_id,
    //         'number' => $number,
    //         'name' => $name,
    //         'path' => $path . "/" . $name,
    //         'extension' => $extension,
    //         'conference_id' => $research->conference_id
    //     ]);

    //     $result->data = $data;
    //     $result->upload = $upload->storeAs($path, $name);
    //     write_logs(__FUNCTION__, "info");

    //     DB::disconnect('conferences');
    //     DB::disconnect('researchs');
    //     DB::disconnect('send_suggestion_researchs');
    //     return $result;
    // }

    protected function file($request)
    {
        $conference = Conference::where('status', 1)->first();
        $result = new SendSuggestionResearch;
        $suggestion = SendSuggestionResearch::select(DB::raw('COUNT(topic_id) as count_topic_id'))->where('topic_id', $request->topic_id)->where('file_admin_send', '!=', '')->first();
        $this->validation($request);
        if ($request->file('admin_send_file')) {
            $upload = $request->file('admin_send_file');
            $extension = $upload->extension();

            $count = 1;
            if ($suggestion->count_topic_id > 0) {
                $count = $suggestion->count_topic_id + 1;
            }

            $name = 'บทความ_' . strval($request->topic_id) . "_" . $count . "." . $extension;
            $path = 'public/ประชุมวิชาการ ' . $conference->year  . '/ไฟล์บทความผู้ทรงส่งมา/' . strval($request->topic_id);

            $data = array_filter([
                'conference_id' => auth()->user()->conference_id,
                'user_admin_id' => auth()->user()->id,
                'user_expert_id' => $request->expert_receive_id,
                'topic_id' => $request->topic_id,
                'file_admin_send' => $name,
                'path_admin_send' => $path . "/" . $name,
                'extension_admin_send' => $extension,
            ]);

            $result->data = $data;
            $result->upload = $upload->storeAs($path, $name);
        } else {
            $data = array_filter([
                'conference_id' => auth()->user()->conference_id,
                'user_admin_id' => auth()->user()->id,
                'user_expert_id' => $request->expert_receive_id,
                'topic_id' => $request->topic_id,
            ]);
            $result->data = $data;
        }

        write_logs(__FUNCTION__, "info");

        DB::disconnect('conferences');
        DB::disconnect('send_suggestion_researchs');
        return $result;
    }

    public function index()
    {
        $conference = Conference::where('status', 1)->first();

        $suggestions = SendSuggestionResearch::select(
            'send_suggestion_researchs.id AS sug_id',
            'send_suggestion_researchs.conference_id AS conference_id',
            'send_suggestion_researchs.user_admin_id AS user_admin_id',
            'send_suggestion_researchs.user_expert_id AS user_expert_id',
            'send_suggestion_researchs.topic_id AS topic_id',
            'send_suggestion_researchs.file_admin_send AS file_admin_send',
            'send_suggestion_researchs.path_admin_send AS path_admin_send',
            'send_suggestion_researchs.extension_admin_send AS extension_admin_send',
            'send_suggestion_researchs.file_expert_receive AS file_expert_receive',
            'send_suggestion_researchs.path_expert_receive AS path_expert_receive',
            'send_suggestion_researchs.extension_expert_receive AS extension_expert_receive',
            'users.prefix AS prefix',
            'users.fullname AS fullname',
            'users.sex AS sex',
            'users.phone AS phone',
            'users.institution AS institution',
            'users.position_id AS position_id',
            'users.person_attend AS person_attend',
            'users.email AS email',
        )
            ->leftjoin('users', 'users.id', '=', 'send_suggestion_researchs.user_expert_id')
            ->leftjoin('conferences', 'send_suggestion_researchs.conference_id', '=', 'conferences.id')
            ->where('conferences.status', 1)
            ->where('send_suggestion_researchs.user_expert_id', auth()->user()->id)
            ->where('send_suggestion_researchs.path_admin_send', '!=', '')
            ->get();


        DB::disconnect('send_suggestion_researchs');
        DB::disconnect('conferences');
        return view('frontend.pages.suggestion', compact('suggestions', 'conference'));
    }

    protected function store(Request $request, $link)
    {
        SendSuggestionResearch::create($this->file($request, $link)->data);


        write_logs(__FUNCTION__, "info");
        alert('สำเร็จ', 'อัพโหลดข้อเสนอแนะสำเร็จ', 'success')->showConfirmButton('ปิด', '#3085d6');

        DB::disconnect('send_suggestion_researchs');
        return back()->with('success', 'อัพโหลดข้อเสนอแนะสำเร็จ');
    }

    public function destroy($id)
    {
        $_suggestion = SendSuggestionResearch::find($id);
        if (Storage::exists($_suggestion->path_admin_send)) {
            Storage::delete($_suggestion->path_admin_send);
        }
        $delete_file = SendSuggestionResearch::where('id', $id)->delete();
        write_logs(__FUNCTION__, "warning");

        DB::disconnect('send_suggestion_researchs');
        return response()->json($delete_file);
    }
}
