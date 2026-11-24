<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scheme_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheme_id')
                ->constrained('schemes', 'id')->cascadeOnDelete();
            $table->foreignId('module_id')
                ->constrained('modules', 'id')->cascadeOnDelete();
            // к какому модулю прикреплено для древовидного крепления
            $table->foreignId('parent_scheme_modules_id')->nullable()
                ->constrained('scheme_modules')->nullOnDelete();

            $table->unique(['scheme_id', 'module_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheme_modules');
    }
};
