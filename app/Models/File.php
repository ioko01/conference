<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'file_word',
        'file_pdf',
        'file_poster',
        'file_payment',
        'date_payment',
        'address_payment'
    ];
}