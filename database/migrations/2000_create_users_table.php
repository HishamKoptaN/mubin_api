<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    public function up(): void
    {    
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('active')->comment('active - inactive');
            $table->string('account_number')->unique();
            $table->string('online_offline')->default('online')->comment('online - offline');
            $table->string('token')->unique();
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('email')->unique();
            $table->string("image")->nullable();
            $table->string("address")->nullable();
            $table->string("phone")->nullable();
            $table->unsignedDouble("balance")->nullable();
            $table->text("comment")->default('');
            $table->text("account_info")->default('');
            $table->foreignId("plan_id")->default('1')->constrained('plans');
            $table->foreignId("refered_by")->nullable()->constrained('users');
            $table->string('confirmation_code')->nullable();
            $table->string("phone_verified_at")->nullable();
            $table->string('refcode')->unique();
            $table->timestamp("phone_verification_code")->nullable();
            $table->timestamp("upgraded_at")->useCurrent();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp("inactivate_end_at")->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
           Schema::create('user_has_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unique(['user_id', 'permission_id']);
        });

          Schema::create('user_has_roles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->unique(['user_id', 'role_id']);
        });
    }

    public function down(): void
    {       
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('role_has_permissions');
    }
};
