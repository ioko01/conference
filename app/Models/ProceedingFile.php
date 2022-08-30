<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProceedingFile extends Model
{
    use HasFactory;
    protected $table = 'proceeding_files';
    protected $fillable = [
        'conference_id',
        'user_id',
        'topic_id',
        'name',
        'link',
        'path',
        'extension'
    ];
}
