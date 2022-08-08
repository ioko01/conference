<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    use HasFactory;
    protected $table = 'manuals';
    protected $fillable = [
        'user_id',
        'notice',
        'name',
        'link',
        'name_file',
        'path_file',
        'ext_file',
        'conference_id'
    ];
}
