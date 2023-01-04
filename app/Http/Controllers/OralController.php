<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Faculty;
use App\Models\PresentOral;
use App\Models\Tip;
use Illuminate\Support\Facades\DB;

class OralController extends Controller
{
    public function index()
    {
        $conference = Conference::where('status', 1)->first();
        $tips = Tip::where('group', '1')->get();
        $present_orals = PresentOral::select(
            'present_orals.id as id',
            'present_orals.topic_th as topic_th',
            'present_orals.present_oral_id as present_oral_id',
            'present_orals.time_start as time_start',
            'present_orals.time_end as time_end',
            'faculties.name as name',
            'conferences.status_present_oral as status_present_oral'
        )
            ->leftjoin('faculties', 'faculties.id', 'present_orals.faculty_id')
            ->leftjoin('conferences', 'conferences.id', 'present_orals.conference_id')
            ->where('conferences.status', 1)
            ->orderBy(DB::raw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(present_oral_id , "0", ""),"1",""),"2",""),"3",""),"4",""),"5",""),"6",""),"7",""),"8",""),"9",""), LENGTH(present_oral_id)'))
            ->get();

        $faculties = Faculty::get();

        $colors = ["primary", "info", "warning", "success", "danger"];

        DB::disconnect('conferences');
        DB::disconnect('tips');
        DB::disconnect('present_orals');
        DB::disconnect('faculties');

        return view('frontend.pages.oral', compact('present_orals', 'conference', 'faculties', 'colors', 'tips'));
    }
}
