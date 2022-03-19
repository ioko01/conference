<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    //
    public function index(Request $request)
    {
        return Storage::download($request->file);
    }
}
