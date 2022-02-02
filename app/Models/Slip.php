<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slip extends Model
{
    use HasFactory;
    protected $table = 'slips';
    protected $fillable = [
        'topic_id',
        'name',
        'path',
        'address',
        'date'
    ];
}