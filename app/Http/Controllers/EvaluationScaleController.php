<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationScaleRequest;
use App\Http\Requests\UpdateEvaluationScaleRequest;
use App\Models\EvaluationScale;
use App\Services\ActivityLogService;

class EvaluationScaleController extends Controller
{
    /**
     * Mostrar listado.
     */
    public function index()
    {
        $evaluationScales = EvaluationScale::orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-scales.index',
            compact('evaluationScales')
        );
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view(
            'configuracion.evaluation-scales.create'
        );
    }

    /**
     * Guardar registro.
     */
    public function store(StoreEvaluationScaleRequest $request)
    {
$evaluationScale = EvaluationScale::create(
    $request->validated()
);

ActivityLogService::log([
    'module' => 'Escalas de evaluación',
    'action' => 'Crear',
    'description' => 'Creó la escala "' . $evaluationScale->name . '".',
    'record_id' => $evaluationScale->id,
]);
        return redirect()
            ->route('evaluation-scales.index')
            ->with(
                'success',
                'Escala creada correctamente.'
            );
    }

    /**
     * Mostrar detalle.
     */
    public function show($id)
    {
        $evaluationScale = EvaluationScale::findOrFail($id);

        return view(
            'configuracion.evaluation-scales.show',
            compact('evaluationScale')
        );
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $evaluationScale = EvaluationScale::findOrFail($id);

        return view(
            'configuracion.evaluation-scales.edit',
            compact('evaluationScale')
        );
    }

    /**
     * Actualizar registro.
     */
    public function update(
        UpdateEvaluationScaleRequest $request,
        $id
    ) {
        $evaluationScale = EvaluationScale::findOrFail($id);

        $evaluationScale->update(
            $request->validated()
        );

        ActivityLogService::log([
    'module' => 'Escalas de evaluación',
    'action' => 'Actualizar',
    'description' => 'Actualizó la escala "' . $evaluationScale->name . '".',
    'record_id' => $evaluationScale->id,
]);

        return redirect()
            ->route('evaluation-scales.index')
            ->with(
                'success',
                'Escala actualizada correctamente.'
            );
    }

    /**
     * Activar o desactivar registro.
     */
    public function destroy($id)
    {
        $evaluationScale = EvaluationScale::findOrFail($id);

        $evaluationScale->is_active = !$evaluationScale->is_active;

        $evaluationScale->save();

        ActivityLogService::log([
    'module' => 'Escalas de evaluación',
    'action' => $evaluationScale->is_active
        ? 'Activar'
        : 'Desactivar',
    'description' => $evaluationScale->is_active
        ? 'Activó la escala "' . $evaluationScale->name . '".'
        : 'Desactivó la escala "' . $evaluationScale->name . '".',
    'record_id' => $evaluationScale->id,
]);

        $message = $evaluationScale->is_active
            ? 'Escala activada correctamente.'
            : 'Escala desactivada correctamente.';

        return redirect()
            ->route('evaluation-scales.index')
            ->with('success', $message);
    }
}