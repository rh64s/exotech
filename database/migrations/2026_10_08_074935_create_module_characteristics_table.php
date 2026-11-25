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
        Schema::create('module_characteristics', function (Blueprint $table) {
            $table->id();
            $table->text('value_string')->nullable();
            $table->float('value_float')->nullable();
            $table->integer('value_int')->nullable();
            $table->boolean('value_bool')->nullable();
            $table->foreignId('module_id')->constrained('modules');
            $table->foreignId('characteristic_id')->constrained('characteristics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_characteristics');
    }
};
