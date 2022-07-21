<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;
    protected $table = 'lines';
    protected $fillable = [
        'conference_id',
        'user_id',
        'name',
        'link',
        'path',
        'extension'
    ];
}
