<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PersonalNote extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_uuid'];

    public function user()
    {
        return $this->hasMany(User::class, 'user_uuid', 'uuid');
    }
}
