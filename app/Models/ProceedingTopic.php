<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProceedingTopic extends Model
{
    use HasFactory;
    protected $table = 'proceeding_topics';
    protected $fillable = [
        'conference_id',
        'user_id',
        'topic',
        'position'
    ];
}
