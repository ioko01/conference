<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentOral extends Model
{
    use HasFactory;
    protected $table = 'present_orals';
    protected $fillable = [
        'user_id',
        'topic_th',
        'present_oral_id',
        'faculty_id',
        'time_start',
        'time_end',
        'conference_id'
    ];
}
