<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupTask extends Model
{
    protected $fillable = [
        'title', 'content', 'deadline', 'unit_id', 'group_id', 'created_by'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }

    public function notification()
    {
        return $this->morphMany(Notification::class, 'type');
    }
}
