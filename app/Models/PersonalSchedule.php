<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalSchedule extends Model
{
    protected $fillable = [
        'title', 'content', 'start_datetime', 'end_datetime', 'user_uuid'
    ];

    public function notification()
    {
        return $this->morphMany(Notification::class, 'type');
    }
}
