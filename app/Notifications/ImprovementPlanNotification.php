<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ImprovementPlanNotification extends Notification
{
    public function __construct(public int $planId, public string $message) {}
    public function via(object $notifiable): array { return ['database']; }
    public function toArray(object $notifiable): array
    {
        return ['plan_id' => $this->planId, 'message' => $this->message];
    }
}
