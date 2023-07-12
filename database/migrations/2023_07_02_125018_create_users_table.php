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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('address', 100)->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('avatar', 255)->nullable();
            $table->enum('role', ['admin', 'gym-owner', 'user'])->default('user');
            $table->timestamp('last_login_at')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
