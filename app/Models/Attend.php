<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attend extends Model
{
    use HasFactory;
    protected $table = "attends";
    protected $fillable = [
        'prefix',
        'fullname',
        'sex',
        'phone',
        'institution',
        'position_id',
        'kota_id',
        'person_attend',
        'email',
        'conference_id'
    ];
}
