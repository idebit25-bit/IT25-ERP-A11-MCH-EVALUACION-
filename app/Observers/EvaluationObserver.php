<?php

namespace App\Observers;

use App\Models\{Evaluation, User};
use App\Notifications\EvaluationNotification;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class EvaluationObserver implements ShouldHandleEventsAfterCommit
{
    public function created(Evaluation $evaluation): void
    {
        $this->notify($evaluation, 'Se te ha asignado la evaluación #'.$evaluation->id.'.');
    }

    public function updated(Evaluation $evaluation): void
    {
        if (! $evaluation->wasChanged(['user_id', 'evaluator_id', 'evaluation_date', 'status'])) return;

        $message = match (true) {
            $evaluation->wasChanged('status') && $evaluation->status === 'draft' => 'Se reabrió la evaluación #'.$evaluation->id.' para que el colaborador corrija sus respuestas.',
            $evaluation->wasChanged('status') && $evaluation->status === 'completed' => 'Se completó la evaluación #'.$evaluation->id.'.',
            $evaluation->wasChanged('status') && $evaluation->status === 'cancelled' => 'Se canceló la evaluación #'.$evaluation->id.'.',
            default => 'Se actualizó la asignación, fecha o estado de la evaluación #'.$evaluation->id.'.',
        };
        $this->notify($evaluation, $message);
    }

    private function notify(Evaluation $evaluation, string $message): void
    {
        User::whereIn('id', array_filter([$evaluation->user_id, $evaluation->evaluator_id]))
            ->where('status', 'active')->each(function (User $user) use ($evaluation, $message) {
                $user->notify(new EvaluationNotification($evaluation->id, $message));
            });
    }
}
