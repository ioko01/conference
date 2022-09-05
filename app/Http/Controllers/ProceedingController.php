<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Faculty;
use App\Models\ProceedingFile;
use App\Models\ProceedingResearch;
use App\Models\ProceedingTopic;
use Illuminate\Http\Request;

class ProceedingController extends Controller
{
    //

    public function index($year)
    {
        $conference = Conference::where('year', $year)->first();
        $proceedings = ProceedingFile::select(
            'proceeding_topics.topic as topic',
            'proceeding_topics.position as position',
            'proceeding_files.name as name',
            'proceeding_files.link as link',
            'proceeding_files.path as path',
            'proceeding_files.extension as extension'
        )
            ->leftjoin('proceeding_topics', 'proceeding_topics.id', 'proceeding_files.topic_id')
            ->where('proceeding_files.conference_id', $conference->id)
            ->orderBy('proceeding_topics.position')
            ->get();

        $proceeding_researchs = ProceedingResearch::select(
            'proceeding_researchs.number as number',
            'proceeding_researchs.topic as topic',
            'proceeding_researchs.faculty_id as faculty_id',
            'faculties.name as faculty_name',
            'presents.name as present_name',
            'proceeding_researchs.name as file_name',
            'proceeding_researchs.path as path',
        )
            ->leftjoin('faculties', 'faculties.id', 'proceeding_researchs.faculty_id')
            ->leftjoin('presents', 'presents.id', 'proceeding_researchs.present_id')
            ->where('proceeding_researchs.conference_id', $conference->id)
            ->get();

        $faculties = Faculty::get();

        $topics = [];
        $i = 0;
        $j = 0;
        for ($i = 0; $i < count($proceedings); $i++) {
            if ($i == 0) {
                $topics[$j] = $proceedings[$i]->topic;
                $j++;
            } elseif ($topics[$j - 1] != $proceedings[$i]->topic) {
                $topics[$j] = $proceedings[$i]->topic;
                $j++;
            }
        }

        return view('frontend.pages.proceeding', compact('year', 'conference', 'proceedings', 'topics', 'faculties', 'proceeding_researchs'));
    }
}
