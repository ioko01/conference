<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\SendSuggestionResearch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExpertUserController extends Controller
{
    //
    public function index($id)
    {
        $users = User::leftjoin('conferences', 'users.conference_id', '=', 'conferences.id')
            ->where('conferences.status', 1)
            ->where('users.id', $id)
            ->where('users.person_attend', 'expert')
            ->where('users.position_id', 4)
            ->get();

        DB::disconnect('users');
        return response()->json($users);
    }

    public function get_file_expert($topic_id)
    {
    }

    public function get_expert_with_json(){
        $expert = User::select(
            'users.id as expert_id',
            'users.prefix as expert_prefix',
            'users.fullname as expert_fullname',
            'users.phone as expert_phone',
            'users.institution as expert_institution',
            'users.email as expert_email'
        )
            ->where('users.person_attend', 'expert')
            ->leftjoin('conferences', 'users.conference_id', '=', 'conferences.id')
            ->where('conferences.status', 1)
            ->get();

        DB::disconnect('users');
        return response()->json($expert);
    }

    protected function validation($request)
    {
        write_logs(__FUNCTION__, "error");
        return $request->validate([
            'topic_id' => 'required',
            'expert_receive_id' => 'required',
            'admin_send_file' => 'mimes:pdf|max:10240'
        ]);
    }

    public function get_expert_user($topic_id)
    {
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
            ->where('send_suggestion_researchs.topic_id', $topic_id)
            ->get();


        DB::disconnect('send_suggestion_researchs');
        return response()->json($suggestions);
    }

    public function get_expert_user_with_id($id, $topic_id)
    {
        $suggestions = SendSuggestionResearch::select(
            'send_suggestion_researchs.id AS sug_id',
            'send_suggestion_researchs.conference_id AS conference_id',
            'send_suggestion_researchs.user_admin_id AS user_admin_id',
            'send_suggestion_researchs.user_expert_id AS user_expert_id',
            'send_suggestion_researchs.topic_id AS topic_id',
            'send_suggestion_researchs.file_admin_send AS file_admin_send',
            'send_suggestion_researchs.path_admin_send AS path_admin_send',
            'send_suggestion_researchs.extension_admin_send AS extension_admin_send',
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
            ->where('send_suggestion_researchs.user_expert_id', $id)
            ->where('send_suggestion_researchs.topic_id', $topic_id)
            ->get();


        DB::disconnect('send_suggestion_researchs');
        return response()->json($suggestions);
    }

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

            $name = 'ไฟล์ที่ส่งไปให้ผู้ทรง_บทความ_' . strval($request->topic_id) . "_" . $count . "." . $extension;
            $path = 'public/ประชุมวิชาการ ' . $conference->year  . '/ไฟล์บทความส่งให้ผู้ทรงอ่าน/' . strval($request->topic_id);

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

    protected function add_file_expert(Request $request)
    {
        $create = $this->file($request)->data;
        $id = SendSuggestionResearch::create($create)->id;

        write_logs(__FUNCTION__, "info");

        DB::disconnect('send_suggestion_researchs');
        return response()->json([$create, $id]);
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

    public function destroy_name($id)
    {
        // $_suggestion = SendSuggestionResearch::find($id);
        $delete_expert_name = SendSuggestionResearch::where('user_expert_id', $id)->delete();
        write_logs(__FUNCTION__, "warning");

        DB::disconnect('send_suggestion_researchs');
        return response()->json($delete_expert_name);
    }
}
