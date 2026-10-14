<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('improvement_plans', function (Blueprint $table) {
            $table->id();
            // El esquema importado puede usar IDs de distinto tamaño; las relaciones
            // se validan en la aplicación sin alterar tablas históricas.
            $table->unsignedBigInteger('evaluation_id')->unique();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('created_by');
            $table->string('title', 180);
            $table->text('objective');
            $table->string('status', 20)->default('active')->index();
            $table->unsignedInteger('version')->default(1);
            $table->json('source_result');
            $table->timestamp('closed_at')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->timestamps();
        });
        Schema::create('improvement_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('improvement_plan_id')->constrained()->restrictOnDelete();
            $table->string('description', 1000);
            $table->unsignedBigInteger('responsible_id')->index();
            $table->date('due_date')->index();
            $table->unsignedTinyInteger('progress')->default(0);
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
        });
        Schema::create('improvement_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('improvement_plan_id')->constrained()->restrictOnDelete();
            $table->unsignedBigInteger('action_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('event', 80);
            $table->text('note');
            $table->json('changes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('improvement_updates');
        Schema::dropIfExists('improvement_actions');
        Schema::dropIfExists('improvement_plans');
    }
};
