<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\ProceedingFile;
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

        return view('frontend.pages.proceeding', compact('year', 'conference', 'proceedings', 'topics'));
    }
}
