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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->string('types')->nullable(); // e.g., "amount" | "duration" | "reason"
            $table->string('value')->nullable();
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->string('status')->default('active'); // active | inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
