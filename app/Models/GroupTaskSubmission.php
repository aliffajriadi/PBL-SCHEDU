<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTaskSubmission extends Model
{
    protected $fillable = [
        'description', 'score', 'user_uuid', 'group_task_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function file()
    {
        return $this->morphMany(TaskFileSubmission::class, 'fileable');
    }
}
