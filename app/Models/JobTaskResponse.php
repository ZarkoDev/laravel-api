<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobTaskResponse extends AppModel
{
    use HasFactory;

    protected $fillable = [
        'job_task_id',
        'status_code',
        'response',
        'error',
    ];

    public function task()
    {
        return $this->belongsTo('App\Models\JobTask', 'job_task_id');
    }

    public function user()
    {
        return $this->belongsToThrough('App\Models\User', 'App\JobTask');
    }
}
