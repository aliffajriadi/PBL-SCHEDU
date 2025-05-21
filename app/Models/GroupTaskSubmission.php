<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTaskSubmission extends Model
{
    protected $fillable = [
        'description', 'score', 'user_uuid', 'group_task_id'
    ];

    
}
