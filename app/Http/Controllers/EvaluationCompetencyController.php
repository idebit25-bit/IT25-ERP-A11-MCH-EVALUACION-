<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationCompetencyRequest;
use App\Http\Requests\UpdateEvaluationCompetencyRequest;
use App\Models\EvaluationCategory;
use App\Models\EvaluationCompetency;
use App\Services\ActivityLogService;

class EvaluationCompetencyController extends Controller
{
    /**
     * Mostrar listado.
     */
    public function index()
    {
        $evaluationCompetencies = EvaluationCompetency::with('category')
            ->orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-competencies.index',
            compact('evaluationCompetencies')
        );
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $categories = EvaluationCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-competencies.create',
            compact('categories')
        );
    }

    /**
     * Guardar registro.
     */
    public function store(StoreEvaluationCompetencyRequest $request)
    {
$evaluationCompetency = EvaluationCompetency::create(
    $request->validated()
);

ActivityLogService::log([
    'module' => 'Competencias',
    'action' => 'Crear',
    'description' => 'Creó la competencia "' . $evaluationCompetency->name . '".',
    'record_id' => $evaluationCompetency->id,
]);

        return redirect()
            ->route('evaluation-competencies.index')
            ->with(
                'success',
                'Competencia creada correctamente.'
            );
    }

    /**
     * Mostrar detalle.
     */
    public function show($id)
    {
        $evaluationCompetency = EvaluationCompetency::with('category')
            ->findOrFail($id);

        return view(
            'configuracion.evaluation-competencies.show',
            compact('evaluationCompetency')
        );
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $evaluationCompetency = EvaluationCompetency::findOrFail($id);

        $categories = EvaluationCategory::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-competencies.edit',
            compact(
                'evaluationCompetency',
                'categories'
            )
        );
    }

    /**
     * Actualizar registro.
     */
    public function update(
        UpdateEvaluationCompetencyRequest $request,
        $id
    ) {
        $evaluationCompetency = EvaluationCompetency::findOrFail($id);

        $evaluationCompetency->update(
            $request->validated()
        );
        
        ActivityLogService::log([
    'module' => 'Competencias',
    'action' => 'Actualizar',
    'description' => 'Actualizó la competencia "' . $evaluationCompetency->name . '".',
    'record_id' => $evaluationCompetency->id,
]);

        return redirect()
            ->route('evaluation-competencies.index')
            ->with(
                'success',
                'Competencia actualizada correctamente.'
            );
    }

    /**
     * Activar o desactivar registro.
     */
    public function destroy($id)
    {
        $evaluationCompetency = EvaluationCompetency::findOrFail($id);

        $evaluationCompetency->is_active = !$evaluationCompetency->is_active;

        $evaluationCompetency->save();

        ActivityLogService::log([
    'module' => 'Competencias',
    'action' => $evaluationCompetency->is_active
        ? 'Activar'
        : 'Desactivar',
    'description' => $evaluationCompetency->is_active
        ? 'Activó la competencia "' . $evaluationCompetency->name . '".'
        : 'Desactivó la competencia "' . $evaluationCompetency->name . '".',
    'record_id' => $evaluationCompetency->id,
]);

        $message = $evaluationCompetency->is_active
            ? 'Competencia activada correctamente.'
            : 'Competencia desactivada correctamente.';

        return redirect()
            ->route('evaluation-competencies.index')
            ->with('success', $message);
    }
}