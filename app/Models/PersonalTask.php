<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalTask extends Model
{
    protected $fillable = [
        'title', 'content', 'deadline', 'user_uuid', 'is_finished'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function notification()
    {
        return $this->morphMany(Notification::class, 'type');
    }
}
