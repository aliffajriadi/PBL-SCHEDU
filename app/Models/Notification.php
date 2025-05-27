<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title', 'content', 'visible_schedule', 'is_reminder', 'group_id', 'type_type', 'type_id'
    ];

    public function status()
    {
        return $this->hasMany(NotificationStatus::class, 'notif_id', 'id');
    }

    public function notification()
    {
        return $this->morphTo();
    }
}
