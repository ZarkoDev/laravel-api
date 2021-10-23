<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class JobTask extends AppModel
{
    use HasFactory, Notifiable;

    const STATUS_CREATED = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAILED = 3;

    const TYPE_DOMAIN = 1;

    protected $fillable = [
        'user_id',
        'type',
        'value',
        'status',
    ];

    public function isFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function response()
    {
        return $this->hasOne('App\Models\JobTaskResponse', 'job_task_id');
    }
}
