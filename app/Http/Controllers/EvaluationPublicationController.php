<?php

namespace App\Http\Controllers;

use App\Models\{Evaluation, User};
use App\Notifications\EvaluationNotification;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationPublicationController extends Controller
{
    public function review(Request $request, int $id)
    {
        $problem = DB::transaction(function () use ($request, $id) {
            $evaluation = Evaluation::lockForUpdate()->findOrFail($id);
            abort_unless($evaluation->evaluator_id == $request->user()->id, 403, 'Solo el evaluador asignado puede registrar la revisión.');
            if ($evaluation->status !== 'completed') return 'La evaluación aún no está completada o fue reabierta. El colaborador debe enviar sus respuestas antes de revisarla.';
            if ($evaluation->reviewed_at) return 'La revisión ya fue registrada. Consulta el estado actualizado de la evaluación.';
            if (! $evaluation->answers()->exists()) return 'La evaluación figura como completada, pero no tiene respuestas guardadas. Solicita al Super Admin que la reabra con un motivo para que el colaborador pueda responderla.';
            $data = $request->validate(['review_notes' => ['required', 'string', 'max:2000']], [
                'review_notes.required' => 'Escribe las observaciones de tu revisión.',
                'review_notes.max' => 'Las observaciones no deben superar los 2000 caracteres.',
            ]);
            $evaluation->forceFill($data + ['reviewed_at' => now(), 'reviewed_by' => $request->user()->id])->save();
            $this->log($evaluation, 'Revisar evaluación', $data['review_notes']);
            User::where('status', 'active')->whereHas('accessRoles', fn ($q) => $q->whereIn('name', ['Admin', 'Super Admin']))
                ->with('accessRoles.permissions')->get()->filter(fn ($user) => $user->hasModulePermission('evaluaciones.gestionar'))
                ->each(fn ($user) => $user->notify(new EvaluationNotification($id, 'La evaluación #'.$id.' fue revisada y está pendiente de validación.')));
        });
        if ($problem) {
            if ($request->expectsJson()) abort(409, $problem);
            return redirect()->route('mis-evaluaciones.show', $id)->withErrors(['review_notes' => $problem])->withInput($request->only('review_notes'));
        }
        return redirect()->route('mis-evaluaciones.show', $id)->with('success', 'Revisión registrada. El resultado está pendiente de validación administrativa.');
    }

    public function validateResult(Request $request, int $id)
    {
        abort_unless($request->user()->hasModulePermission('evaluaciones.gestionar'), 403);
        DB::transaction(function () use ($request, $id) {
            $evaluation = Evaluation::lockForUpdate()->findOrFail($id);
            abort_unless($evaluation->status === 'completed' && $evaluation->reviewed_at && ! $evaluation->validated_at, 409, 'La evaluación debe estar revisada y pendiente de validación.');
            $evaluation->forceFill(['validated_at' => now(), 'validated_by' => $request->user()->id])->save();
            $this->log($evaluation, 'Validar resultado', 'Se autorizó el resultado revisado para su publicación.');
        });
        return back()->with('success', 'Resultado validado. Puedes publicarlo para que el colaborador lo consulte.');
    }

    public function publish(Request $request, int $id)
    {
        abort_unless($request->user()->hasModulePermission('evaluaciones.gestionar'), 403);
        DB::transaction(function () use ($request, $id) {
            $evaluation = Evaluation::lockForUpdate()->findOrFail($id);
            abort_unless($evaluation->status === 'completed' && $evaluation->reviewed_at && $evaluation->validated_at && ! $evaluation->published_at, 409, 'Valida el resultado antes de publicarlo. No se puede publicar dos veces.');
            $evaluation->forceFill(['published_at' => now(), 'published_by' => $request->user()->id])->save();
            $this->log($evaluation, 'Publicar resultado', 'El resultado quedó disponible para el colaborador.');
            $evaluation->user?->notify(new EvaluationNotification($id, 'Ya puedes consultar el resultado publicado de tu evaluación #'.$id.'.'));
        });
        return back()->with('success', 'Resultado publicado. Se notificó al colaborador.');
    }

    private function log(Evaluation $evaluation, string $action, string $description): void
    {
        ActivityLogService::log(['module' => 'Evaluaciones', 'action' => $action, 'record_id' => $evaluation->id, 'description' => $description]);
    }
}
