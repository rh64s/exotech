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
        // хар-ки товаров
        Schema::create('characteristics', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // вот это человеко-читаемое
            $table->string('unit')->nullable(); // это единица измерения (физ)
            $table->string('data_type')->default('string'); // это тип данных для админ-панели
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characteristics');
    }
};
