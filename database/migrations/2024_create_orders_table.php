<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string("image_one")->nullable();
            $table->string("image_two")->nullable();
            $table->string("video")->nullable();
            $table->string("place")->nullable();
            $table->foreignId("branch_id")->constrained('branches');
            $table->foreignId('client_id')->constrained('clients');
        },
    );
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
