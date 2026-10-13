<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class DocumentFileService
{
    public function validPath(?string $path): bool
    {
        return is_string($path) && preg_match('~^documents/[a-zA-Z0-9_-]+\.pdf$~i', $path) === 1;
    }

    public function exists(?string $path): bool
    {
        return $this->validPath($path) && Storage::disk('documents')->exists($path);
    }

    public function store(UploadedFile $file): string
    {
        try {
            $path = $file->store('documents', 'documents');
            if (! $path || ! $this->exists($path)) throw new \RuntimeException('No se guardó el PDF.');
            return $path;
        } catch (Throwable $exception) {
            report($exception);
            throw ValidationException::withMessages(['document' => 'No se pudo guardar el PDF. Se conservó el documento anterior. Inténtalo nuevamente.']);
        }
    }

    public function delete(?string $path): void
    {
        if (! $this->validPath($path)) return;
        try {
            Storage::disk('documents')->delete($path);
        } catch (Throwable $exception) {
            // Un archivo privado huérfano no debe invalidar un guardado ya confirmado.
            report($exception);
        }
    }
}
