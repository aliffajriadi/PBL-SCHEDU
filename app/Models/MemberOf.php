<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberOf extends Model
{
    protected $fillable = ['user_uuid', 'group_id', 'verified'];
}
