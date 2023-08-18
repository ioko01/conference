<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Research;
use App\Models\StatusResearch;
use App\Models\Comment;
use App\Models\SendSuggestionResearch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageResearchController extends Controller
{
    public function index()
    {
        $topic_status = StatusResearch::get();
        $data = Research::select(
            'researchs.id as id',
            'researchs.topic_id as topic_id',
            'status_researchs.name as topic_status',
            'topic_th',
            'topic_en',
            'presenter',
            'faculties.name as faculty',
            'branches.name as branch',
            'degrees.name as degree',
            'presents.name as present',
            'users.phone as phone',
            'users.institution as institution',
            'users.address as address',
            'users.email as email',
            'users.person_attend as attend',
            'kotas.name as kota',
            'words.name as word',
            'pdf.name as pdf',
            'slips.name as payment',
            'slips.address as address_payment',
            'slips.date as date_payment',
            'words.path as word_path',
            'pdf.path as pdf_path',
            'slips.path as payment_path',
            'researchs.topic_status as status_id',
            'researchs.created_at as created_at',
            'researchs.updated_at as updated_at',
        )
            ->leftjoin('faculties', 'researchs.faculty_id', '=', 'faculties.id')
            ->leftjoin('branches', 'researchs.branch_id', '=', 'branches.id')
            ->leftjoin('degrees', 'researchs.degree_id', '=', 'degrees.id')
            ->leftjoin('presents', 'researchs.present_id', '=', 'presents.id')
            ->leftjoin('users', 'researchs.user_id', '=', 'users.id')
            ->leftjoin('kotas', 'users.kota_id', '=', 'kotas.id')
            ->leftjoin('words', 'researchs.topic_id', '=', 'words.topic_id')
            ->leftjoin('pdf', 'researchs.topic_id', '=', 'pdf.topic_id')
            ->leftjoin('slips', 'researchs.topic_id', '=', 'slips.topic_id')
            ->leftjoin('status_researchs', 'researchs.topic_status', '=', 'status_researchs.id')
            ->leftjoin('conferences', 'researchs.conference_id', '=', 'conferences.id')
            ->where('conferences.status', 1)
            ->orderBy('id')
            ->get();

        $comments = Comment::select(
            'comments.topic_id as comment_topic_id',
            'comments.name as comment_name',
            'comments.path as comment_path',
            'comments.extension as comment_ext',
            'comments.created_at as created_at',
            'comments.status as comment_status',
        )
            ->leftjoin('researchs', 'researchs.topic_id', '=', 'comments.topic_id')
            ->get();

        $suggestions = SendSuggestionResearch::get();

        DB::disconnect('status_researchs');
        DB::disconnect('researchs');
        DB::disconnect('comments');
        return view('backend.pages.manage_research', compact('data', 'topic_status', 'comments', 'suggestions'));
    }


    public function index_ajax()
    {

        $comments = Comment::select(
            'comments.topic_id as comment_topic_id',
            'comments.name as comment_name',
            'comments.path as comment_path',
            'comments.extension as comment_ext',
            'comments.created_at as comment_update',
            'comments.status as comment_status',
        )
            ->leftjoin('researchs', 'researchs.topic_id', '=', 'comments.topic_id')
            ->get();

        $suggestions = SendSuggestionResearch::get();

        DB::disconnect('status_researchs');
        DB::disconnect('researchs');
        DB::disconnect('comments');
        foreach ($suggestions as $suggestion) {
            $suggestion->path = Storage::url($suggestion->path);
        }

        foreach ($comments as $comment) {
            $comment->comment_path = Storage::url($comment->comment_path);
        }

        $data_json['suggestion'] = $suggestions;
        $data_json['comments'] = $comments;
        return response()->json($data_json);
    }
}
