<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationTypeRequest;
use App\Http\Requests\UpdateEvaluationTypeRequest;
use App\Models\EvaluationType;
use App\Services\ActivityLogService;

class EvaluationTypeController extends Controller
{
    /**
     * Mostrar listado.
     */
    public function index()
    {
        $evaluationTypes = EvaluationType::orderBy('name')->get();

        return view(
            'configuracion.evaluation-types.index',
            compact('evaluationTypes')
        );
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('configuracion.evaluation-types.create');
    }

    /**
 * Guardar registro.
 */
public function store(StoreEvaluationTypeRequest $request)
{

    $evaluationType = EvaluationType::create(
        $request->validated()
    );

    ActivityLogService::log([

        'module' => 'Tipos de evaluación',

        'action' => 'Crear',

        'description' => 'Creó el tipo de evaluación "' .
            $evaluationType->name .
            '".',

        'record_id' => $evaluationType->id,

    ]);

    return redirect()
        ->route('evaluation-types.index')
        ->with(
            'success',
            'Tipo de evaluación creado correctamente.'
        );
}

    

    /**
     * Mostrar detalle.
     */
    public function show($id)
    {
        $evaluationType = EvaluationType::findOrFail($id);

        return view(
            'configuracion.evaluation-types.show',
            compact('evaluationType')
        );
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $evaluationType = EvaluationType::findOrFail($id);

        return view(
            'configuracion.evaluation-types.edit',
            compact('evaluationType')
        );
    }

/**
 * Actualizar registro.
 */
public function update(
    UpdateEvaluationTypeRequest $request,
    $id
) {
    $evaluationType = EvaluationType::findOrFail($id);

    $evaluationType->update(
        $request->validated()
    );

    ActivityLogService::log([

        'module' => 'Tipos de evaluación',

        'action' => 'Actualizar',

        'description' => 'Actualizó el tipo de evaluación "' .
            $evaluationType->name .
            '".',

        'record_id' => $evaluationType->id,

    ]);

    return redirect()
        ->route('evaluation-types.index')
        ->with(
            'success',
            'Tipo de evaluación actualizado correctamente.'
        );
}

/**
 * Activar o desactivar registro.
 */
public function destroy($id)
{
    $evaluationType = EvaluationType::findOrFail($id);

    $evaluationType->is_active = !$evaluationType->is_active;

    $evaluationType->save();

    ActivityLogService::log([

        'module' => 'Tipos de evaluación',

        'action' => $evaluationType->is_active
            ? 'Activar'
            : 'Desactivar',

        'description' => $evaluationType->is_active
            ? 'Activó el tipo de evaluación "' .
                $evaluationType->name .
                '".'
            : 'Desactivó el tipo de evaluación "' .
                $evaluationType->name .
                '".',

        'record_id' => $evaluationType->id,

    ]);

    $message = $evaluationType->is_active
        ? 'Tipo de evaluación activado correctamente.'
        : 'Tipo de evaluación desactivado correctamente.';

    return redirect()
        ->route('evaluation-types.index')
        ->with(
            'success',
            $message
        );
}
}