<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class EvaluationNotification extends Notification
{
    public function __construct(public int $evaluationId, public string $message) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return ['evaluation_id' => $this->evaluationId, 'message' => $this->message];
    }
}
