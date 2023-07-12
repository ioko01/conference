<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Research;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Charts\UserChart;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // $path = public_path('storage');
        // $storage = File::exists($path);

        $admin = User::leftjoin('conferences', 'conferences.id', 'users.conference_id')
            ->where('conferences.status', 1)
            ->where('users.is_admin', '>', 0)
            ->where('users.email_verified_at', '!=', null)
            ->get();

        $users = User::leftjoin('conferences', 'conferences.id', 'users.conference_id')
            ->where('conferences.status', 1)
            ->where('users.is_admin', 0)
            ->where('users.email_verified_at', '!=', null)
            ->get();

        $researchs = Research::select(
            '*',
            'researchs.created_at as research_created'
        )
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->where('conferences.status', 1)
            ->orderBy('researchs.topic_id', 'desc')
            ->get();

        $researchs_distinct = Research::select(
            DB::raw('COUNT(DISTINCT TRIM(researchs.topic_th)) AS topic_th')
        )
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->where('conferences.status', 1)
            ->first();

        $researchs_not_sendfile = Research::select(
            DB::raw('COUNT(DISTINCT TRIM(researchs.topic_th)) AS topic_th')
        )
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->leftjoin('pdf', 'pdf.topic_id', 'researchs.topic_id')
            ->leftjoin('words', 'words.topic_id', 'researchs.topic_id')
            ->where('conferences.status', 1)
            ->where([['words.name', NULL], ['pdf.name', NULL]])
            ->first();

        $users_not_verify_email = User::leftjoin('conferences', 'conferences.id', 'users.conference_id')
            ->where('conferences.status', 1)
            ->where('users.is_admin', 0)
            ->where('users.email_verified_at', null)
            ->get();

        $conference = Conference::where('status', 1)->first();

        $count = Research::select(
            DB::raw('COUNT(TRIM(researchs.topic_th)) AS count_research'),
            DB::raw('users.position_id AS position_id')
        )
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->leftjoin('users', 'users.id', 'researchs.user_id')->where('conferences.status', 1)
            ->groupBy('users.position_id')
            ->get();



        $chart = new UserChart;
        $chart->options([
            "yAxis" => [
                "title" => [
                    "text" => "จำนวนบทความ"
                ]
            ],
        ]);

        $researchs_in = 0;
        $researchs_out = 0;
        $researchs_kota = 0;
        foreach ($count as $value) {
            if ($value->position_id == 1) {
                $researchs_in = $value->count_research;
            } else if ($value->position_id == 2) {
                $researchs_out = $value->count_research;
            } else if ($value->position_id == 3) {
                $researchs_kota = $value->count_research;
            }
        }

        $chart->labels(['บุคลากรภายใน', 'บุคลากรภายนอก', 'เจ้าภาพร่วม']);
        $chart->displayLegend(false);
        $chart->dataset('บทความ', 'column', [$researchs_in, $researchs_out, $researchs_kota])->color("#343a40");


        $count_distinct = Research::select(
            DB::raw('COUNT(DISTINCT TRIM(researchs.topic_th)) AS count_research_distinct'),
            DB::raw('users.position_id AS position_id')
        )
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->leftjoin('users', 'users.id', 'researchs.user_id')->where('conferences.status', 1)
            ->groupBy('users.position_id')
            ->get();



        $chart_distinct = new UserChart;
        $chart_distinct->options([
            "yAxis" => [
                "title" => [
                    "text" => "จำนวนบทความ"
                ]
            ],
        ]);

        $researchs_in_distinct = 0;
        $researchs_out_distinct = 0;
        $researchs_kota_distinct = 0;
        foreach ($count_distinct as $value) {
            if ($value->position_id == 1) {
                $researchs_in_distinct = $value->count_research_distinct;
            } else if ($value->position_id == 2) {
                $researchs_out_distinct = $value->count_research_distinct;
            } else if ($value->position_id == 3) {
                $researchs_kota_distinct = $value->count_research_distinct;
            }
        }
        
        $chart_distinct->labels(['บุคลากรภายใน', 'บุคลากรภายนอก', 'เจ้าภาพร่วม']);
        $chart_distinct->displayLegend(false);
        $chart_distinct->dataset('บทความ', 'column', [$researchs_in_distinct, $researchs_out_distinct, $researchs_kota_distinct])->color("#ffc107");


        $count_sendfile_distinct = Research::select(
            DB::raw('COUNT(DISTINCT TRIM(researchs.topic_th)) AS count_research_not_sendfile_distinct'),
            DB::raw('users.position_id AS position_id')
        )
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->leftjoin('users', 'users.id', 'researchs.user_id')
            ->leftjoin('words', 'words.topic_id', 'researchs.topic_id')
            ->leftjoin('pdf', 'pdf.topic_id', 'researchs.topic_id')
            ->where('conferences.status', 1)
            ->where([['words.name', NULL], ['pdf.name', NULL]])
            ->groupBy('users.position_id')
            ->get();



        $chart_sendfile_distinct = new UserChart;
        $chart_sendfile_distinct->options([
            "yAxis" => [
                "title" => [
                    "text" => "จำนวนบทความ"
                ]
            ],
        ]);

        $researchs_in_sendfile_distinct = 0;
        $researchs_out_sendfile_distinct = 0;
        $researchs_kota_sendfile_distinct = 0;
        foreach ($count_sendfile_distinct as $value) {
            if ($value->position_id == 1) {
                $researchs_in_sendfile_distinct = intval($researchs_in - $value->count_research_not_sendfile_distinct);
            } else if ($value->position_id == 2) {
                $researchs_out_sendfile_distinct = intval($researchs_out - $value->count_research_not_sendfile_distinct);
            } else if ($value->position_id == 3) {
                $researchs_kota_sendfile_distinct = intval($researchs_kota - $value->count_research_not_sendfile_distinct);
            }
        }

        $chart_sendfile_distinct->labels(['บุคลากรภายใน', 'บุคลากรภายนอก', 'เจ้าภาพร่วม']);
        $chart_sendfile_distinct->displayLegend(false);
        $chart_sendfile_distinct->dataset('บทความ', 'column', [$researchs_in_sendfile_distinct, $researchs_out_sendfile_distinct, $researchs_kota_sendfile_distinct])->color("#28a745");

        DB::disconnect('conferences');
        DB::disconnect('researchs');
        DB::disconnect('users');
        return view('backend.pages.dashboard', compact('researchs_kota_distinct', 'researchs_out_distinct', 'researchs_in_distinct', 'chart_distinct', 'researchs', 'users', 'conference', 'users_not_verify_email', 'admin', 'chart', 'researchs_in', 'researchs_out', 'researchs_kota', 'researchs_distinct', 'researchs_not_sendfile', 'researchs_in_sendfile_distinct', 'researchs_out_sendfile_distinct', 'researchs_kota_sendfile_distinct', 'chart_sendfile_distinct'));
    }

    // protected function storage()
    // {
    //     $path = public_path('storage');
    //     $storage = File::exists($path);
    //     if (!$storage) {
    //         \Illuminate\Support\Facades\Artisan::call('storage:link');
    //         write_logs(__FUNCTION__, "info");
    //         alert('สำเร็จ', 'เปิดใช้งาน Storage link สำเร็จ', 'success');
    //         return back()->with('success', true);
    //     }

    //     write_logs(__FUNCTION__, "error");
    //     alert('ผิดพลาด', 'ไม่สามารถปิดใช้งาน Storage Link ได้', 'error');
    //     return back()->with('success', true);
    // }
}
