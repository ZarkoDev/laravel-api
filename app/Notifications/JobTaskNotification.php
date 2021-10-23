<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class JobTaskNotification extends Notification
{
    public function __construct()
    {
        
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->action('Your task is completed and you can see it here ', route('showTaskResponse', 123));
    }
}
