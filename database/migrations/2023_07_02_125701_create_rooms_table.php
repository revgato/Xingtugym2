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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('address', 100);
            $table->integer('price');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('numberOfUsers')->default(0);
            $table->float('rating')->nullable();
            $table->boolean('pool')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('sauna')->default(false);
            $table->boolean('coach')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('is_admin_approved')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
