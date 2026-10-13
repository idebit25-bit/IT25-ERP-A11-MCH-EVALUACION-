<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_counters', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedBigInteger('last_number');
        });
        $maximum = 0;
        foreach (DB::table('documents')->pluck('code') as $code) {
            if (preg_match('/^DOC-(\d+)$/', $code, $match)) $maximum = max($maximum, (int) $match[1]);
        }
        DB::table('document_counters')->insert(['id' => 1, 'last_number' => $maximum]);
    }

    public function down(): void
    {
        Schema::dropIfExists('document_counters');
    }
};
