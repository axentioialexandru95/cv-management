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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cvs')->cascadeOnDelete();
            $table->string('title');
            $table->enum('publication_type', ['journal', 'conference', 'book', 'chapter', 'other'])->default('other');
            $table->text('authors');
            $table->string('publication_venue')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('doi')->nullable();
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
