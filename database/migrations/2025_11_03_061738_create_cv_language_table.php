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
        Schema::create('cv_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->enum('listening', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->nullable();
            $table->enum('reading', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->nullable();
            $table->enum('spoken_interaction', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->nullable();
            $table->enum('spoken_production', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->nullable();
            $table->enum('writing', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->nullable();
            $table->boolean('is_native')->default(false);
            $table->text('certificates')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_language');
    }
};
