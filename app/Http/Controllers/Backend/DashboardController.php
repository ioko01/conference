<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\Research;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $path = public_path('storage');
        $storage = File::exists($path);
        $users = User::leftjoin('conferences', 'conferences.id', 'users.conference_id')
            ->where('conferences.status', 1)
            ->get();
        $researchs = Research::select(
            '*',
            'researchs.created_at as research_created'
        )
            ->leftjoin('conferences', 'conferences.id', 'researchs.conference_id')
            ->where('conferences.status', 1)
            ->orderBy('researchs.topic_id', 'desc')
            ->get();

        $conference = Conference::where('status', 1)->first();
        return view('backend.pages.dashboard', compact('storage', 'researchs', 'users', 'conference'));
    }

    protected function storage()
    {
        $path = public_path('storage');
        $storage = File::exists($path);
        if (!$storage) {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
            alert('สำเร็จ', 'เปิดใช้งาน Storage link สำเร็จ', 'success');
            return back()->with('success', true);
        }

        alert('ผิดพลาด', 'ไม่สามารถปิดใช้งาน Storage Link ได้', 'error');
        return back()->with('success', true);
    }
}
