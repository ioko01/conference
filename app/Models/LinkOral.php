<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkOral extends Model
{
    use HasFactory;
    protected $table = 'link_orals';
    protected $fillable = [
        'user_id',
        'room',
        'link',
        'path',
        'extension',
        'faculty_id',
        'conference_id'
    ];
}
