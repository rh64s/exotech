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
        Schema::create('compatible_modules', function (Blueprint $table) {
            $table->foreignId('module_id')->constrained('modules');
            $table->foreignId('compatible_module_id')->constrained('modules');
            $table->primary(['compatible_module_id', 'module_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatible_modules');
    }
};
