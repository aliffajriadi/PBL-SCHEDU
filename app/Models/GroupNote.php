<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupNote extends Model
{
    protected $fillable = ['title', 'content', 'group_id', 'created_by', 'pic'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function notification()
    {
        return $this->morphOne(Notification::class, 'type');
    }
}
