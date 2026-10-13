<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLogService;

class MyEvaluationController extends Controller
{
    private function authorizeView(Request $request, Evaluation $evaluation): void
    {
        abort_unless($request->user()->hasModulePermission('evaluaciones.gestionar')
            || $evaluation->user_id == $request->user()->id
            || $evaluation->evaluator_id == $request->user()->id, 403);
    }

    public function show(Request $request, int $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $this->authorizeView($request, $evaluation);
        $evaluation->load(['user', 'evaluator', 'period', 'evaluationType', 'template.questions.scale.values', 'answers.question', 'reviewer', 'validator', 'publisher']);
        $canRespond = $evaluation->user_id == $request->user()->id && in_array($evaluation->status, ['draft', 'in_progress']);
        $canReview = $request->user()->hasModulePermission('evaluaciones.gestionar') || $evaluation->evaluator_id == $request->user()->id;
        $canSeeResults = $canReview || ($evaluation->status === 'completed' && $evaluation->published_at && $evaluation->user_id == $request->user()->id);
        $questions = $evaluation->template?->questions ?? collect();
        $ready = $questions->isNotEmpty() && $questions->every(fn ($q) => $q->question_type === 'radio' && $q->scale?->values->where('is_active', true)->isNotEmpty());
        return view('evaluaciones.personal', compact('evaluation', 'canRespond', 'canReview', 'canSeeResults', 'questions', 'ready'));
    }

    public function submit(Request $request, int $id)
    {
        DB::transaction(function () use ($request, $id) {
            $evaluation = Evaluation::lockForUpdate()->findOrFail($id);
            abort_unless($evaluation->user_id == $request->user()->id, 403, 'Solo el colaborador evaluado puede enviar sus respuestas.');
            abort_unless(in_array($evaluation->status, ['draft', 'in_progress']), 409, 'Esta evaluación ya no admite respuestas.');
            $questions = $evaluation->template?->questions()->with('scale.values')->get() ?? collect();
            if ($questions->isEmpty() || ! $questions->every(fn ($q) => $q->question_type === 'radio' && $q->scale?->values->where('is_active', true)->isNotEmpty())) {
                throw ValidationException::withMessages(['answers' => 'La plantilla no está lista para responder. Contacta al evaluador.']);
            }
            $rules = ['answers' => ['required', 'array'], 'observations' => ['nullable', 'string', 'max:1000']];
            foreach ($questions as $question) {
                $rules['answers.'.$question->id] = [ $question->pivot->is_required ? 'required' : 'nullable', 'integer', Rule::in($question->scale->values->where('is_active', true)->pluck('id')->all()) ];
            }
            $data = $request->validate($rules, [
                'answers.required' => 'Responde las preguntas antes de enviar.',
                'answers.*.required' => 'Selecciona una respuesta para esta pregunta.',
                'answers.*.in' => 'La opción seleccionada no corresponde a esta pregunta.',
                'observations.max' => 'Las observaciones no deben superar los 1000 caracteres.',
            ]);
            if (array_diff(array_keys($request->input('answers', [])), $questions->pluck('id')->all())) {
                throw ValidationException::withMessages(['answers' => 'Se recibieron preguntas que no pertenecen a la evaluación.']);
            }
            $selected = collect($data['answers'])->filter(fn ($value) => $value !== null && $value !== '');
            if ($selected->isEmpty()) throw ValidationException::withMessages(['answers' => 'Selecciona al menos una respuesta.']);
            $evaluation->answers()->delete();
            foreach ($selected as $questionId => $valueId) {
                $value = $questions->firstWhere('id', $questionId)->scale->values->firstWhere('id', $valueId);
                $evaluation->answers()->create(['question_id' => $questionId, 'answer' => $value->label, 'numeric_value' => $value->numeric_value]);
            }
            $evaluation->update(['observations' => $data['observations'] ?? null, 'total_score' => (float) $evaluation->answers()->avg('numeric_value'), 'status' => 'completed']);
            ActivityLogService::log(['module' => 'Evaluaciones', 'action' => 'Enviar respuestas', 'record_id' => $evaluation->id, 'description' => 'El colaborador envió sus respuestas.']);
        });
        return redirect()->route('mis-evaluaciones.show', $id)->with('success', 'Tus respuestas se guardaron y se notificó al evaluador.');
    }

    public function reopen(Request $request, int $id)
    {
        abort_unless($request->user()->hasAccessRole('Super Admin'), 403);
        $data = $request->validate(['reason' => ['required', 'string', 'min:10', 'max:1000']], [
            'reason.required' => 'Indica el motivo de la reapertura.',
            'reason.min' => 'Describe el motivo con al menos 10 caracteres.',
        ]);
        DB::transaction(function () use ($id, $data) {
            $evaluation = Evaluation::lockForUpdate()->findOrFail($id);
            abort_unless($evaluation->status === 'completed', 409, 'Solo se reabren evaluaciones completadas.');
            ActivityLogService::log(['module' => 'Evaluaciones', 'action' => 'Reabrir evaluación', 'record_id' => $id,
                'description' => json_encode(['motivo' => $data['reason'], 'calificacion_anterior' => $evaluation->total_score, 'observaciones_anteriores' => $evaluation->observations, 'respuestas_anteriores' => $evaluation->answers()->get(['question_id', 'answer', 'numeric_value'])->toArray()], JSON_UNESCAPED_UNICODE)]);
            ActivityLogService::log(['module' => 'Evaluaciones', 'action' => 'Anular revisión y publicación', 'record_id' => $id,
                'description' => json_encode($evaluation->only(['reviewed_at', 'reviewed_by', 'review_notes', 'validated_at', 'validated_by', 'published_at', 'published_by']), JSON_UNESCAPED_UNICODE)]);
            $evaluation->forceFill(['status' => 'draft', 'total_score' => 0, 'reviewed_at' => null, 'reviewed_by' => null, 'review_notes' => null, 'validated_at' => null, 'validated_by' => null, 'published_at' => null, 'published_by' => null])->save();
        });
        return redirect()->route('mis-evaluaciones.show', $id)->with('success', 'Evaluación reabierta. El colaborador puede corregir y enviar nuevamente sus respuestas.');
    }

    public function index(Request $request)
    {
        $filters = $request->validate([
            'status' => ['nullable', Rule::in(['pending', 'completed', 'cancelled'])],
        ]);
        $status = $filters['status'] ?? '';
        $userId = $request->user()->id;
        $query = Evaluation::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)->orWhere('evaluator_id', $userId);
        });
        $counts = (clone $query)->selectRaw('status, COUNT(*) AS aggregate')->groupBy('status')->pluck('aggregate', 'status');
        $pending = ($counts['draft'] ?? 0) + ($counts['in_progress'] ?? 0);
        $completed = $counts['completed'] ?? 0;
        $cancelled = $counts['cancelled'] ?? 0;

        if ($status === 'pending') {
            $query->whereIn('status', ['draft', 'in_progress']);
        } elseif ($status !== '') {
            $query->where('status', $status);
        }

        $evaluations = $query->with(['evaluationType', 'period', 'user', 'evaluator'])
            ->orderByDesc('evaluation_date')->orderByDesc('id')->paginate(15)->withQueryString();

        return view('evaluaciones.mine', compact('evaluations', 'status', 'pending', 'completed', 'cancelled'));
    }
}
