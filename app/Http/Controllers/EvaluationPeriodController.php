<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationPeriodRequest;
use App\Http\Requests\UpdateEvaluationPeriodRequest;
use App\Models\EvaluationPeriod;
use App\Services\ActivityLogService;

class EvaluationPeriodController extends Controller
{
    /**
     * Mostrar listado.
     */
    public function index()
    {
        $evaluationPeriods = EvaluationPeriod::orderBy('year', 'desc')
            ->orderBy('start_date')
            ->get();

        return view(
            'configuracion.evaluation-periods.index',
            compact('evaluationPeriods')
        );
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('configuracion.evaluation-periods.create');
    }

    /**
     * Guardar registro.
     */
    public function store(StoreEvaluationPeriodRequest $request)
    {
        $evaluationPeriod = EvaluationPeriod::create(
    $request->validated()
);

ActivityLogService::log([
    'module' => 'Períodos de evaluación',
    'action' => 'Crear',
    'description' => 'Creó el período "' . $evaluationPeriod->name . '".',
    'record_id' => $evaluationPeriod->id,
]);

        return redirect()
            ->route('evaluation-periods.index')
            ->with('success', 'Período creado correctamente.');
    }

    /**
     * Mostrar detalle.
     */
    public function show($id)
    {
        $evaluationPeriod = EvaluationPeriod::findOrFail($id);

        return view(
            'configuracion.evaluation-periods.show',
            compact('evaluationPeriod')
        );
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $evaluationPeriod = EvaluationPeriod::findOrFail($id);

        return view(
            'configuracion.evaluation-periods.edit',
            compact('evaluationPeriod')
        );
    }

    /**
     * Actualizar registro.
     */
public function update(
    UpdateEvaluationPeriodRequest $request,
    $id
) {
    $evaluationPeriod = EvaluationPeriod::findOrFail($id);

    $evaluationPeriod->update(
        $request->validated()
    );

    ActivityLogService::log([
        'module' => 'Períodos de evaluación',
        'action' => 'Actualizar',
        'description' => 'Actualizó el período "' . $evaluationPeriod->name . '".',
        'record_id' => $evaluationPeriod->id,
    ]);

    return redirect()
        ->route('evaluation-periods.index')
        ->with('success', 'Período actualizado correctamente.');
}
    /**
     * Activar o desactivar registro.
     */
public function destroy($id)
{
    $evaluationPeriod = EvaluationPeriod::findOrFail($id);

    $evaluationPeriod->is_active = !$evaluationPeriod->is_active;

    $evaluationPeriod->save();

    ActivityLogService::log([
        'module' => 'Períodos de evaluación',
        'action' => $evaluationPeriod->is_active
            ? 'Activar'
            : 'Desactivar',
        'description' => $evaluationPeriod->is_active
            ? 'Activó el período "' . $evaluationPeriod->name . '".'
            : 'Desactivó el período "' . $evaluationPeriod->name . '".',
        'record_id' => $evaluationPeriod->id,
    ]);

    $message = $evaluationPeriod->is_active
        ? 'Período activado correctamente.'
        : 'Período desactivado correctamente.';

    return redirect()
        ->route('evaluation-periods.index')
        ->with('success', $message);
}
}