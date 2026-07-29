<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
 public function index()
{
    $documentos = Document::query();

    // Buscar documento
    if (request('search')) {
        $search = request('search');

        $documentos->where(function ($query) use ($search) {
            $query->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
        });
    }

    // Filtrar por tipo
    if (request('tipo')) {
        $documentos->where('type', request('tipo'));
    }

    // Ordenamiento
    $ordenes = [
        'code',
        'name',
        'type',
        'version',
        'expiration_date',
        'created_at',
        'status',
    ];

    if (
        request('order') &&
        in_array(request('order'), $ordenes)
    ) {
        $documentos->orderBy(request('order'));
    } else {
        $documentos->latest();
    }

    $documentos = $documentos->get();
    $totalManuales = Document::where('type', 'Manual')->count();

    $totalFormatos = Document::where('type', 'Formato')->count();

    $totalPoliticas = Document::where('type', 'Política')->count();

   $totalProcedimientos = Document::where('type', 'Procedimiento')->count();

return view(
    'documentos.index',
    compact(
        'documentos',
        'totalManuales',
        'totalFormatos',
        'totalPoliticas',
        'totalProcedimientos'
    )
);

}

public function show($id)
{
    $documento = Document::findOrFail($id);

    return view(
        'documentos.show',
        compact('documento')
    );
}

public function edit($id)
{
    $documento = Document::findOrFail($id);

    return view(
        'documentos.edit',
        compact('documento')
    );
}

public function create()
{
    return view('documentos.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:100',
        'version' => 'required|string|max:50',
        'expiration_date' => 'nullable|date',
        'document' => 'required|file|mimes:pdf|max:5120',
    ]);

    $ultimo = Document::latest('id')->first();

    $numero = $ultimo
        ? ((int) str_replace('DOC-', '', $ultimo->code)) + 1
        : 1;

    $filePath = $request->file('document')->store('documents', 'public');

    Document::create([
        'code' => 'DOC-' . str_pad($numero, 3, '0', STR_PAD_LEFT),
        'name' => $request->name,
        'type' => $request->type,
        'version' => $request->version,
        'status' => 'Vigente',
        'expiration_date' => $request->expiration_date,
        'file_path' => $filePath,
        'created_by' => auth()->id(),
    ]);

    return redirect('/documentos')
        ->with('success', 'Documento registrado correctamente.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:100',
        'version' => 'required|string|max:50',
        'status' => 'required|string|max:50',
        'expiration_date' => 'nullable|date',
        'document' => 'nullable|file|mimes:pdf|max:5120',
    ]);

    $documento = Document::findOrFail($id);

    $datos = [
        'name' => $request->name,
        'type' => $request->type,
        'version' => $request->version,
        'status' => $request->status,
        'expiration_date' => $request->expiration_date,
    ];

    // Reemplazar archivo PDF
    if ($request->hasFile('document')) {

        // Eliminar archivo anterior
        if (
            $documento->file_path &&
            Storage::disk('public')->exists($documento->file_path)
        ) {
            Storage::disk('public')->delete($documento->file_path);
        }

        // Guardar nuevo archivo
        $datos['file_path'] = $request
            ->file('document')
            ->store('documents', 'public');
    }

    $documento->update($datos);

    return redirect('/documentos')
        ->with('success', 'Documento actualizado correctamente.');
}

public function destroy($id)
{
    $documento = Document::findOrFail($id);

    // Eliminar archivo del almacenamiento
    if (
        $documento->file_path &&
        Storage::disk('public')->exists($documento->file_path)
    ) {
        Storage::disk('public')->delete($documento->file_path);
    }

    // Eliminar registro
    $documento->delete();

    return redirect('/documentos')
        ->with('success', 'Documento eliminado correctamente.');
}

public function manuales()
{
    $manuales = Document::where('type', 'Manual')
        ->latest()
        ->get();

    $totalManuales = $manuales->count();

    $manualesVigentes = $manuales
        ->where('status', 'Vigente')
        ->count();

    $proximosVencer = $manuales
        ->filter(function ($manual) {

            if (!$manual->expiration_date) {
                return false;
            }

            return \Carbon\Carbon::parse($manual->expiration_date)
                ->between(now(), now()->addDays(30));

        })
        ->count();

    return view(
        'documentos.manuales',
        compact(
            'manuales',
            'totalManuales',
            'manualesVigentes',
            'proximosVencer'
        )
    );
}

public function formatos()
{
    $formatos = Document::where('type', 'Formato')
        ->latest()
        ->get();

    $totalFormatos = $formatos->count();

    $formatosVigentes = $formatos
        ->where('status', 'Vigente')
        ->count();

    $proximosVencer = $formatos
        ->filter(function ($formato) {

            if (!$formato->expiration_date) {
                return false;
            }

            return \Carbon\Carbon::parse($formato->expiration_date)
                ->between(now(), now()->addDays(30));

        })
        ->count();

    return view(
        'documentos.formatos',
        compact(
            'formatos',
            'totalFormatos',
            'formatosVigentes',
            'proximosVencer'
        )
    );
}

public function politicas()
{
    $politicas = Document::where('type', 'Política')
        ->latest()
        ->get();

    $totalPoliticas = $politicas->count();

    $politicasVigentes = $politicas
        ->where('status', 'Vigente')
        ->count();

    $proximosVencer = $politicas
        ->filter(function ($politica) {

            if (!$politica->expiration_date) {
                return false;
            }

            return \Carbon\Carbon::parse($politica->expiration_date)
                ->between(now(), now()->addDays(30));

        })
        ->count();

    return view(
        'documentos.politicas',
        compact(
            'politicas',
            'totalPoliticas',
            'politicasVigentes',
            'proximosVencer'
        )
    );
}

public function procedimientos()
{
    $procedimientos = Document::where('type', 'Procedimiento')
        ->latest()
        ->get();

    $totalProcedimientos = $procedimientos->count();

    $procedimientosVigentes = $procedimientos
        ->where('status', 'Vigente')
        ->count();

    $proximosVencer = $procedimientos
        ->filter(function ($procedimiento) {

            if (!$procedimiento->expiration_date) {
                return false;
            }

            return \Carbon\Carbon::parse($procedimiento->expiration_date)
                ->between(now(), now()->addDays(30));

        })
        ->count();

    return view(
        'documentos.procedimientos',
        compact(
            'procedimientos',
            'totalProcedimientos',
            'procedimientosVigentes',
            'proximosVencer'
        )
    );
}

}