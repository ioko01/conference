<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendEditStatement extends Model
{
    use HasFactory;
    protected $table = 'send_edit_statements';
    protected $fillable = [
        'user_id',
        'topic_id',
        'name',
        'path',
        'extension',
    ];
}
