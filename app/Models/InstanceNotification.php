<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceNotification extends Model
{
    protected $fillable = [
        'staff_uuid', 'title', 'description', 'is_readed'
    ];

    public function staff()
    {
        return $this->belongsTo(Instance::class, 'staff_uuid', 'uuid');
    }

}
