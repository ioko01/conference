<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    use HasFactory;
}


protected $fillable = [
    'name_th',
    'name_en',
    'research_name',
    'group',
    'group2',
    'volumn',
    'type',
    'person_type',
    'word',
    'pdf',
    'payment',
    'payment_date',
    'payment_adderss'
]