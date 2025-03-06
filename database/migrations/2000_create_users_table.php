<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->id();
                $table->boolean('status')->default(true)->comment('true-false');
                $table->boolean('online_offline')->default(true)->comment('true-false');
                $table->string('firebase_uid')->unique()->nullable();
                $table->timestamps();
            },
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'users',
        );
    }
};
