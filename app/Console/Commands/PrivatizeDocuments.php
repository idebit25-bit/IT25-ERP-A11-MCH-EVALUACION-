<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Services\DocumentFileService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PrivatizeDocuments extends Command
{
    protected $signature = 'documentos:privatizar';
    protected $description = 'Traslada PDFs registrados al disco privado, comprobando su integridad antes de retirar la copia pública.';

    public function handle(DocumentFileService $files): int
    {
        $public = Storage::disk('public');
        $private = Storage::disk('documents');
        $missing = 0;
        foreach (Document::select('file_path')->distinct()->get() as $document) {
            $path = $document->file_path;
            if (! $files->validPath($path)) {
                $this->error('Ruta no válida: no se modificó el archivo.');
                return self::FAILURE;
            }
            if (! $public->exists($path)) {
                if (! $private->exists($path)) $missing++;
                continue;
            }
            // No seguir enlaces que salgan de la carpeta pública del proyecto.
            $source = realpath($public->path($path));
            $root = realpath($public->path(''));
            if (! $source || ! $root || ! str_starts_with($source, rtrim($root, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR)) {
                $this->error('El archivo está fuera del almacenamiento esperado.');
                return self::FAILURE;
            }
            $contents = $public->get($path);
            if (! $private->exists($path)) $private->put($path, $contents);
            if (hash('sha256', $contents) !== hash('sha256', $private->get($path))) {
                $this->error('Las copias no coinciden. Se conservó el archivo público.');
                return self::FAILURE;
            }
            if (! $public->delete($path)) {
                $this->error('No se pudo retirar la copia pública.');
                return self::FAILURE;
            }
        }
        $this->info('Traslado verificado. Archivos no encontrados: '.$missing.'.');
        return $missing ? self::FAILURE : self::SUCCESS;
    }
}
