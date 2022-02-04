<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditResearch extends Model
{
    use HasFactory;

    protected $table = 'edit_researchs';
    protected $fillable = [
        'user_id',
        'topic_id',
        'new_word',
        'new_pdf',
        'path_word',
        'path_pdf',
        'extension_word',
        'extension_pdf',
    ];
}