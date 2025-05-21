<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class TaskFileSubmission extends Model
{
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($model) {
            if(empty($model->{$model->getKeyName()})){
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    
    
    protected $fillable = [
        'submission_id'
    ];

    public $incrementing = false;
    protected $primaryKey = 'file_name';
    protected $keyType = 'string';
    public $timestamps = false;

    
}
