<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SaveDocumentRequest;
use App\Services\DocumentFileService;

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
        ['documento' => $documento, 'fileAvailable' => app(DocumentFileService::class)->exists($documento->file_path)]
    );
}

public function edit($id)
{
    $documento = Document::findOrFail($id);

    return view(
        'documentos.edit',
        ['documento' => $documento, 'fileAvailable' => app(DocumentFileService::class)->exists($documento->file_path)]
    );
}

public function create()
{
    return view('documentos.create');
}

public function store(SaveDocumentRequest $request, DocumentFileService $files)
{
    $data = $request->safe()->except('document');
    $path = $files->store($request->file('document'));
    try {
        DB::transaction(function () use ($data, $path, $request) {
            $counter = DB::table('document_counters')->where('id', 1)->lockForUpdate()->first();
            $number = $counter->last_number;
            do {
                $code = 'DOC-'.str_pad(++$number, 3, '0', STR_PAD_LEFT);
            } while (Document::where('code', $code)->exists());
            DB::table('document_counters')->where('id', 1)->update(['last_number' => $number]);
            Document::create($data + ['code' => $code, 'file_path' => $path, 'created_by' => $request->user()->id]);
        });
    } catch (\Throwable $exception) {
        $files->delete($path);
        throw $exception;
    }
    return redirect('/documentos')->with('success', 'Documento registrado correctamente.');
}

public function update(SaveDocumentRequest $request, $id, DocumentFileService $files)
{
    Document::findOrFail($id);
    $path = $request->hasFile('document') ? $files->store($request->file('document')) : null;
    try {
        $previous = DB::transaction(function () use ($request, $id, $path) {
            $document = Document::lockForUpdate()->findOrFail($id);
            $previous = $document->file_path;
            $data = $request->safe()->except('document');
            if ($path) $data['file_path'] = $path;
            $document->update($data);
            return $previous;
        });
    } catch (\Throwable $exception) {
        if ($path) $files->delete($path);
        throw $exception;
    }
    if ($path && ! Document::where('file_path', $previous)->exists()) $files->delete($previous);
    return redirect('/documentos')->with('success', 'Documento actualizado correctamente.');
}

public function destroy($id, DocumentFileService $files)
{
    $path = DB::transaction(function () use ($id) {
        $document = Document::lockForUpdate()->findOrFail($id);
        $path = $document->file_path;
        $document->delete();
        return $path;
    });
    if (! Document::where('file_path', $path)->exists()) $files->delete($path);
    return redirect('/documentos')->with('success', 'Documento eliminado correctamente.');
}

public function file(Request $request, $id, DocumentFileService $files)
{
    $document = Document::findOrFail($id);
    if (! $files->exists($document->file_path)) {
        return redirect('/documentos/'.$document->id)->with('error', 'El archivo PDF no esta disponible. Solicita al administrador que lo adjunte nuevamente.');
    }
    $name = \Illuminate\Support\Str::slug($document->code.' '.$document->name).'.pdf';
    return Storage::disk('documents')->response($document->file_path, $name,
        ['Content-Type' => 'application/pdf', 'Cache-Control' => 'private, no-store', 'X-Content-Type-Options' => 'nosniff'],
        $request->boolean('download') ? 'attachment' : 'inline');
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