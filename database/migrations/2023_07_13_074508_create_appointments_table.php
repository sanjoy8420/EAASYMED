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
        // In appointments migration
    Schema::create('appointments', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('doctor_id')->nullable(); // Foreign key to doctors table
    $table->string('name')->nullable();  // Patient's name
    $table->string('email')->nullable();
    $table->string('phone')->nullable();
    $table->string('date')->nullable();
    $table->string('message')->nullable();
    $table->string('status')->nullable();
    $table->unsignedBigInteger('user_id')->nullable();  // User ID from Auth system
    $table->timestamps();

    // Create foreign key constraint
    $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
