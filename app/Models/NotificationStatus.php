<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationStatus extends Model
{
    public $incrementing = false;

    protected $primary = 'user_uuid';
    
    protected $fillable = [
        'user_uuid', 'group_id', 'is_read'
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notif_id', 'id');
    }

}
