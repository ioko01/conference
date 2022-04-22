<?php

use App\Models\Conference;

function endDate($enddate)
{
    $day = Conference::select(
        Conference::raw(
            "floor(timestampdiff(second, now(), $enddate)/(60*60*24)) as day"
        )
    )
        ->where('conferences.status', 1)
        ->first();
    return $day;
}
