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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->boolean('need_expert_help');
            $table->string('name');
            $table->timestamp('created_at');
        });

        Schema::create('related_users_to_chat', function (Blueprint $table) {
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignId('chat_id')->constrained('chats');
            $table->primary(['user_id', 'chat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('related_users_to_chat');
        Schema::dropIfExists('chats');
    }
};
