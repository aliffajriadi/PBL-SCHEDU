<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Group extends Model
{
    protected $fillable = ['name', 'group_code', 'instance_uuid', 'pic', 'created_by'];

    public function instance()
    {
        return $this->belongsTo(Instance::class, 'instance_uuid', 'uuid');
    }

    // public function user(){
    //     return $this->belongsTo(User::class, 'pic', 'uuid');
    // }

    public function note()
    {
        return $this->hasMany(GroupNote::class, 'group_id', 'id');
    }

    public function schedule()
    {
        return $this->hasMany(GroupSchedule::class, 'group_id', 'id');
    }

    public function task()
    {
        return $this->hasMany(GroupTask::class, 'group_id', 'id');
    }

    public function member()
    {
        return $this->hasMany(MemberOf::class, 'group_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'uuid');
    }
}
