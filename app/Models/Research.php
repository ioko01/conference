<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'topic_id',
        'topic_th',
        'topic_en',
        'topic_status',
        'presenter',
        'faculty_id',
        'branch_id',
        'degrees_id',
        'present_id',
        'payment',
        'payment_date',
        'payment_adderss',
        'payment_status'
    ];
}