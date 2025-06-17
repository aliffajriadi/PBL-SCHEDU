<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;



use Illuminate\Support\Str;


class Instance extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\InstanceFactory> */
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'instances';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if(empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }


    protected $fillable = ['email', 'instance_name', 'password', 'phone_no', 'address', 'folder_name'];

    public function user()
    {
        return $this->hasMany(User::class, 'instance_uuid', 'uuid');
    }

    public function group()
    {
        return $this->hasMany(Group::class, 'instance_uuid', 'uuid');
    }

    public function notification()
    {
        return $this->hasMany(InstanceNotification::class, 'staff_uuid', 'uuid');
    }
}
