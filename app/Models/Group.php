<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Group extends Model
{
    protected $fillable = ['name', 'group_code', 'instance_uuid', 'pic'];

    public function instance()
    {
        return $this->belongsTo(Staff::class, 'instance_uuid', 'uuid');
    }
}
