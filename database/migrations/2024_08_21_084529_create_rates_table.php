<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['active', 'inactive']);
            $table->foreignId('plan_id')->constrained('plans');
            $table->foreignId('from')->constrained('currencies');
            $table->foreignId('to')->constrained('currencies');
            $table->decimal('selling', 8, 1)->unsigned();
            $table->decimal('buying', 8, 1)->unsigned();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('rates');
    }
};
            
            