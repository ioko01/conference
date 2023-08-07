<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendSuggestionResearch extends Model
{
    use HasFactory;
    protected $table = 'send_suggestion_researchs';
    protected $fillable = [
        'conference_id',
        'user_id',
        'topic_id',
        'number',
        'name',
        'path',
        'extension',
    ];
}
