<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class JobTaskNotification extends Notification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->action('TODO', route('todo', 123));
    }
}
