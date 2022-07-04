<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    //
    public function show($id)
    {
        $video = Video::where('topic_id', $id)->get()->first();
        return response()->json($video);
    }
}
