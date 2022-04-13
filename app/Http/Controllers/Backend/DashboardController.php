<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $path = public_path('storage');
        $storage = File::exists($path);

        return view('backend.pages.dashboard', compact('storage'));
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
