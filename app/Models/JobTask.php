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

    public function getStatusNames()
    {
        return [
            self::STATUS_CREATED => 'Created',
            self::STATUS_IN_PROGRESS => 'InProgress',
            self::STATUS_SUCCESS => 'Successful',
            self::STATUS_FAILED => 'Failed',
        ];
    }

    public function getStatusName()
    {
        return $this->getStatusNames()[$this->status] ?? null;
    }

    public function isFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function response()
    {
        return $this->hasOne(JobTaskResponse::class, 'job_task_id');
    }
}
