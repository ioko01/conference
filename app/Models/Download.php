<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;
    protected $table = 'downloads';
    protected $fillable = [
        'user_id',
        'name',
        'link',
        'name_file',
        'path_file',
        'ext_file',
        'conference_id'
    ];
}
