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
        Schema::table('cvs', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->after('is_active');
            $table->string('public_slug', 20)->unique()->nullable()->after('is_public');
            $table->unsignedBigInteger('public_views_count')->default(0)->after('public_slug');
            $table->timestamp('last_viewed_at')->nullable()->after('public_views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cvs', function (Blueprint $table) {
            $table->dropColumn(['is_public', 'public_slug', 'public_views_count', 'last_viewed_at']);
        });
    }
};
