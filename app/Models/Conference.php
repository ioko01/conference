<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $table = 'conferences';
    protected $fillable = [
        'user_id',
        'name',
        'status',
        'year',
        'start',
        'final',
        'status_conference',
        'start_research',
        'end_research',
        'status_payment',
        'end_payment',
        'status_attend',
        'end_attend',
        'status_research_edit',
        'end_research_edit',
        'status_research_edit_two',
        'end_research_edit_two',
        'status_poster_and_video',
        'end_poster_and_video',
        'status_poster_and_video_two',
        'end_poster_and_video_two'
    ];
}
