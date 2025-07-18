<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if(empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'gender',
        'birth_date',
        'is_teacher',
        'instance_uuid',
        'profile_pic'        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function instance()
    {
        return $this->belongsTo(Instance::class, 'instance_uuid', 'uuid');
    }

    public function note()
    {
        return $this->hasMany(PersonalNote::class, 'user_uuid', 'uuid');
    }

    public function member_of()
    {
        return $this->hasMany(MemberOf::class, 'user_uuid', 'uuid');
    }

    public function make_note()
    {
        return $this->hasMany(GroupNote::class, 'user_uuid', 'uuid');
    }

    public function notification()
    {
        return $this->hasMany(NotificationStatus::class, 'user_uuid', 'uuid');
    }
}
