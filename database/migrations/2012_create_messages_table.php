<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->string('is_file')->default('no');
            $table->string('file_name')->nullable();
            $table->string('file_original_name')->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_size')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('chat_id')->constrained('chats')->cascadeOnDelete();
            $table->timestamp('readed_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
