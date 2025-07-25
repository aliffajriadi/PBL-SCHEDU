<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceNotification extends Model
{
    protected $fillable = [
        'instance_uuid', 'title', 'description', 'is_readed'
    ];

    public function staff()
    {
        return $this->belongsTo(Instance::class, 'instance_uuid', 'uuid');
    }

}
