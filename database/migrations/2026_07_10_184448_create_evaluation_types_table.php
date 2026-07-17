<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar migración.
     */
    public function up(): void
    {
        Schema::create('evaluation_types', function (Blueprint $table) {

            $table->id();

            // Nombre del tipo de evaluación
            $table->string('name',100);

            // Descripción
            $table->text('description')->nullable();

            // Estado
            $table->boolean('is_active')->default(true);

            // Usuario que creó el registro
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Revertir migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_types');
    }
};