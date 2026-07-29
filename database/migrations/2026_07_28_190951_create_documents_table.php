<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {

            $table->id();

            $table->string('code', 20)->unique();

            $table->string('name');

            $table->enum('type', [
                'Manual',
                'Formato',
                'Política',
                'Procedimiento'
            ]);

            $table->string('version', 20);

            $table->string('file_path');

            $table->enum('status', [
                'Vigente',
                'Actualizado',
                'Vencido'
            ])->default('Vigente');

            $table->date('expiration_date')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Revertir la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
