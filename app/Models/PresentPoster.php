<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentPoster extends Model
{
    use HasFactory;
    protected $table = 'present_posters';
    protected $fillable = [
        'user_id',
        'topic_th',
        'present_poster_id',
        'faculty_id',
        'link',
        'path',
        'extension',
        'conference_id',
        'time_start',
        'time_end'
    ];
}
