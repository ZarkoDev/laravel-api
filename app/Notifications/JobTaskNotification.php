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
            ->action(__('custom.mail_task_creation_notify'), route('task.response'))
            ->line('Send it with parameter task_id=' . $this->task->id);
    }
}
