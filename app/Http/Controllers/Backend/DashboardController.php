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

class DashboardController extends Controller
{
    public function index()
    {
        $path = public_path('storage');
        $storage = File::exists($path);

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

        $users_not_verify_email = User::leftjoin('conferences', 'conferences.id', 'users.conference_id')
            ->where('conferences.status', 1)
            ->where('users.is_admin', 0)
            ->where('users.email_verified_at', null)
            ->get();

        $conference = Conference::where('status', 1)->first();

        $researchs_in = Research::select('*')
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->leftjoin('users', 'users.id', 'researchs.user_id')
            ->where('conferences.status', 1)
            ->where('users.position_id', 1)
            ->get();

        $researchs_out = Research::select('*')
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->leftjoin('users', 'users.id', 'researchs.user_id')
            ->where('conferences.status', 1)
            ->where('users.position_id', 2)
            ->get();

        $researchs_kota = Research::select('*')
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->leftjoin('users', 'users.id', 'researchs.user_id')
            ->where('conferences.status', 1)
            ->where('users.position_id', 3)
            ->get();

        $chart = new UserChart;
        $chart->options([
            "yAxis" => [
                "title" => [
                    "text" => "จำนวนบทความ"
                ]
            ],
        ]);
        $chart->labels(['บุคลากรภายใน', 'บุคลากรภายนอก', 'เจ้าภาพร่วม']);
        $chart->displayLegend(false);
        $chart->dataset('บทความ', 'column', [count($researchs_in), count($researchs_out), count($researchs_kota)])->color("#343a40");

        return view('backend.pages.dashboard', compact('storage', 'researchs', 'users', 'conference', 'users_not_verify_email', 'admin', 'chart', 'researchs_in', 'researchs_out', 'researchs_kota'));
    }

    protected function storage()
    {
        $path = public_path('storage');
        $storage = File::exists($path);
        if (!$storage) {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            write_logs(__FUNCTION__, "info");
            alert('สำเร็จ', 'เปิดใช้งาน Storage link สำเร็จ', 'success');
            return back()->with('success', true);
        }

        write_logs(__FUNCTION__, "error");
        alert('ผิดพลาด', 'ไม่สามารถปิดใช้งาน Storage Link ได้', 'error');
        return back()->with('success', true);
    }
}
