<?php

use App\Enums\AttachmentInterfaceType;
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
        Schema::create('attachment_interfaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', AttachmentInterfaceType::values());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_interfaces');
    }
};
