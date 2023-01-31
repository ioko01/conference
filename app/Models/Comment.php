<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = [
        'user_id',
        'topic_id',
        'name',
        'path',
        'extension',
        'conference_id',
        'status'
    ];
}