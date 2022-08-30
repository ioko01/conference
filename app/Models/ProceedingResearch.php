<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProceedingResearch extends Model
{
    use HasFactory;
    protected $table = 'proceeding_researchs';
    protected $fillable = [
        'conference_id',
        'user_id',
        'number',
        'topic',
        'faculty_id',
        'branch_id',
        'degree_id',
        'present_id',
        'name',
        'path',
        'extension'
    ];
}
