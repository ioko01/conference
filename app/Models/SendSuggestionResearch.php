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
        'user_admin_id',
        'user_expert_id',
        'topic_id',
        'file_admin_send',
        'path_admin_send',
        'extension_admin_send',
        'file_expert_receive',
        'path_expert_receive',
        'extension_expert_receive',
    ];
}
