<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    final protected string $COMPATIBLE_MODULES_PRIMARY_KEY = 'compatible_modules_primary_key';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('module_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->decimal(
                'price',
                config('app.custom.money_range.total'),
                config('app.custom.money_range.places')
            );
            $table->foreignId('module_type_id')
                ->constrained('module_types', 'id')->restrictOnDelete();
            $table->timestamps();
        });

        Schema::create('compatible_modules', function (Blueprint $table) {
            $table->foreignId('module_id')
                ->constrained('modules', 'id')->cascadeOnDelete();
            $table->foreignId('compatible_module_id')
                ->constrained('modules', 'id')->cascadeOnDelete();
            $table->primary(
                ['module_id', 'compatible_module_id'],
                $this->COMPATIBLE_MODULES_PRIMARY_KEY
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_types');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('compatible_modules');
    }
};
