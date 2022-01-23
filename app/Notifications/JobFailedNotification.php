<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Events\JobFailed;

class JobFailedNotification extends Notification
{
    use Queueable;

    public function __construct(private JobFailed $event)
    {
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
                    ->error()
                    ->subject(config('app.name') . ': JobFailed: ' . $this->event->job->resolveName())
                    ->line('The job failed to process.')
                    ->line('Name: ' . $this->event->job->resolveName())
                    ->line('Error: ' . $this->event->exception->getMessage())
                    ->line('Body: ' . $this->event->job->getRawBody())
                    ->line('Trace: ' . $this->event->exception->getTraceAsString());
    }
}
