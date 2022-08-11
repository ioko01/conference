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
        'end_research',
        'status_payment',
        'end_payment',
        'status_consideration',
        'consideration',
        'status_research_edit',
        'end_research_edit',
        'status_attend',
        'end_attend',
        'status_research_edit_two',
        'end_research_edit_two',
        'status_poster_and_video',
        'end_poster_and_video',
        'status_present_poster',
        'status_notice_attend',
        'notice_attend',
        'status_present',
        'present',
        'status_proceeding',
        'proceeding'
    ];
}
