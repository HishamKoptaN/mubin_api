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
                $table->string('online_offline')->default('online')->comment('online - offline');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('password');
                $table->string('email')->unique();
                $table->string("image")->nullable();
                $table->string("address")->nullable();
                $table->string("phone")->nullable();
                $table->text("comment")->default('');
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
