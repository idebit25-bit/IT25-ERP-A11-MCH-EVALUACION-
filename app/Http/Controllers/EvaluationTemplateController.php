<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluationTemplateRequest;
use App\Http\Requests\UpdateEvaluationTemplateRequest;
use App\Models\EvaluationTemplate;
use App\Models\EvaluationType;
use App\Services\ActivityLogService;

class EvaluationTemplateController extends Controller
{
    /**
     * Mostrar listado.
     */
    public function index()
    {
        $evaluationTemplates = EvaluationTemplate::with('evaluationType')
            ->withCount('templateQuestions')
            ->orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-templates.index',
            compact('evaluationTemplates')
        );
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $evaluationTypes = EvaluationType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-templates.create',
            compact('evaluationTypes')
        );
    }

    /**
     * Guardar registro.
     */
    public function store(StoreEvaluationTemplateRequest $request)
    {
        
        $evaluationTemplate = EvaluationTemplate::create(
            $request->validated()
        );
        
        ActivityLogService::log([
            'module' => 'Plantillas de evaluación',
            'action' => 'Crear',
            'description' => 'Creó la plantilla "' . $evaluationTemplate->name . '".',
            'record_id' => $evaluationTemplate->id,
        ]);

        return redirect()
            ->route('evaluation-templates.index')
            ->with(
                'success',
                'Plantilla creada correctamente.'
            );
    }

    /**
     * Mostrar detalle.
     */
    public function show($id)
    {
        $evaluationTemplate = EvaluationTemplate::with([
            'evaluationType'
        ])->findOrFail($id);

        return view(
            'configuracion.evaluation-templates.show',
            compact('evaluationTemplate')
        );
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $evaluationTemplate = EvaluationTemplate::findOrFail($id);

        $evaluationTypes = EvaluationType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'configuracion.evaluation-templates.edit',
            compact(
                'evaluationTemplate',
                'evaluationTypes'
            )
        );
    }

/**
 * Actualizar registro.
 */
public function update(
    UpdateEvaluationTemplateRequest $request,
    $id
) {
    $evaluationTemplate = EvaluationTemplate::findOrFail($id);

    $evaluationTemplate->update(
        $request->validated()
    );

    ActivityLogService::log([
        'module' => 'Plantillas de evaluación',
        'action' => 'Actualizar',
        'description' => 'Actualizó la plantilla "' . $evaluationTemplate->name . '".',
        'record_id' => $evaluationTemplate->id,
    ]);

    return redirect()
        ->route('evaluation-templates.index')
        ->with(
            'success',
            'Plantilla actualizada correctamente.'
        );
}

    /**
     * Activar o desactivar registro.
     */
    public function destroy($id)
    {
        $evaluationTemplate = EvaluationTemplate::findOrFail($id);

        $evaluationTemplate->is_active =
            !$evaluationTemplate->is_active;

        $evaluationTemplate->save();

        
        ActivityLogService::log([
            'module' => 'Plantillas de evaluación',
            'action' => $evaluationTemplate->is_active
                ? 'Activar'
                : 'Desactivar',
            'description' => $evaluationTemplate->is_active
                ? 'Activó la plantilla "' . $evaluationTemplate->name . '".'
                : 'Desactivó la plantilla "' . $evaluationTemplate->name . '".',
            'record_id' => $evaluationTemplate->id,
        ]);

        $message = $evaluationTemplate->is_active
            ? 'Plantilla activada correctamente.'
            : 'Plantilla desactivada correctamente.';

        return redirect()
            ->route('evaluation-templates.index')
            ->with('success', $message);
    }
}