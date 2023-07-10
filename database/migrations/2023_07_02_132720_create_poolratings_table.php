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
        Schema::create('poolratings', function (Blueprint $table) {
            // primary key both 2 columns
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade')->onUpdate('cascade');
            $table->float('rating')->nullable();
            $table->primary(['room_id', 'review_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poolratings');
    }
};
