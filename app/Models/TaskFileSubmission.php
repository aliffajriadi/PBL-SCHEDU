<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class TaskFileSubmission extends Model
{    
    protected $fillable = [
        'stored_name', 'original_name', 'submission_id', 'fileable_type', 'fileable_id'
    ];

    public $timestamps = false;

    public function submission()
    {
        return $this->morphTo();
    }

}
