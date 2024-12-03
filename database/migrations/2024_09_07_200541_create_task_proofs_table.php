<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_proofs', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pending')->comment(
                'pending-accepted-rejected',
            );
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('task_id');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('user_tasks');
    }
};
