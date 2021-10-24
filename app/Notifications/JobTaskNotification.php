<?php

namespace App\Notifications;

use App\Models\JobTask;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class JobTaskNotification extends Notification
{
    private $task;

    public function __construct(JobTask $jobTask)
    {
        $this->task = $jobTask;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->action('Your task is completed and you can see it here ', route('task.response', $this->task->id));
    }
}
