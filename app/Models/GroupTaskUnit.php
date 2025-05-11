<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTaskUnit extends Model
{
    protected $fillable = [
        'name', 'group_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'id', 'group_id');
    }

    public function task()
    {
        return $this->hasMany(GroupTask::class, 'unit_id', 'id');
    }
}
