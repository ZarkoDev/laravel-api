<?php

namespace App\Events;

use App\Models\JobTask;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobTaskCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jobTask;

    public function __construct(JobTask $jobTask)
    {
        $this->jobTask = $jobTask;
    }

    // public function broadcastOn()
    // {
    //     return new PrivateChannel('tasks');
    // }
}
