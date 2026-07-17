<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationCategoryRequest;
use App\Http\Requests\UpdateEvaluationCategoryRequest;
use App\Models\EvaluationCategory;
use App\Services\ActivityLogService;

class EvaluationCategoryController extends Controller
{
    /**
     * Mostrar listado.
     */
    public function index()
    {
        $evaluationCategories = EvaluationCategory::orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-categories.index',
            compact('evaluationCategories')
        );
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view(
            'configuracion.evaluation-categories.create'
        );
    }

    /**
     * Guardar registro.
     */
    public function store(StoreEvaluationCategoryRequest $request)
    {
$evaluationCategory = EvaluationCategory::create(
    $request->validated()
);

ActivityLogService::log([
    'module' => 'Categorías de evaluación',
    'action' => 'Crear',
    'description' => 'Creó la categoría "' . $evaluationCategory->name . '".',
    'record_id' => $evaluationCategory->id,
]);

        return redirect()
            ->route('evaluation-categories.index')
            ->with(
                'success',
                'Categoría creada correctamente.'
            );
    }

    /**
     * Mostrar detalle.
     */
    public function show($id)
    {
        $evaluationCategory = EvaluationCategory::findOrFail($id);

        return view(
            'configuracion.evaluation-categories.show',
            compact('evaluationCategory')
        );
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $evaluationCategory = EvaluationCategory::findOrFail($id);

        return view(
            'configuracion.evaluation-categories.edit',
            compact('evaluationCategory')
        );
    }

    /**
     * Actualizar registro.
     */
    public function update(
        UpdateEvaluationCategoryRequest $request,
        $id
    ) {
        $evaluationCategory = EvaluationCategory::findOrFail($id);

 $evaluationCategory->update(
    $request->validated()
);

ActivityLogService::log([
    'module' => 'Categorías de evaluación',
    'action' => 'Actualizar',
    'description' => 'Actualizó la categoría "' . $evaluationCategory->name . '".',
    'record_id' => $evaluationCategory->id,
]);

        return redirect()
            ->route('evaluation-categories.index')
            ->with(
                'success',
                'Categoría actualizada correctamente.'
            );
    }

    /**
     * Activar o desactivar registro.
     */
    public function destroy($id)
    {
        $evaluationCategory = EvaluationCategory::findOrFail($id);

        $evaluationCategory->is_active = !$evaluationCategory->is_active;

        $evaluationCategory->save();

        ActivityLogService::log([
    'module' => 'Categorías de evaluación',
    'action' => $evaluationCategory->is_active
        ? 'Activar'
        : 'Desactivar',
    'description' => $evaluationCategory->is_active
        ? 'Activó la categoría "' . $evaluationCategory->name . '".'
        : 'Desactivó la categoría "' . $evaluationCategory->name . '".',
    'record_id' => $evaluationCategory->id,
]);

        $message = $evaluationCategory->is_active
            ? 'Categoría activada correctamente.'
            : 'Categoría desactivada correctamente.';

        return redirect()
            ->route('evaluation-categories.index')
            ->with('success', $message);
    }
}