<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use HasFactory;

    protected $table = 'researchs';
    protected $fillable = [
        'user_id',
        'topic_id',
        'topic_th',
        'topic_en',
        'topic_status',
        'presenter',
        'faculty_id',
        'branch_id',
        'degree_id',
        'present_id',
        'conference_id'
    ];
}