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
        Schema::create('frame_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('frame_id')->constrained()->cascadeOnDelete();
            $table->foreignId('body_zone_id')->constrained();
            $table->foreignId('attachment_interface_id')->constrained();
            $table->unsignedInteger('quantity');
            $table->unique(['frame_id', 'body_zone_id', 'attachment_interface_id'], 'frame_slot_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frame_slots');
    }
};
