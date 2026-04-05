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
        Schema::table('coaching_sessions', function (Blueprint $table) {
            $table->unsignedInteger('cache_creation_input_tokens')->nullable()->after('completion_tokens');
            $table->unsignedInteger('cache_read_input_tokens')->nullable()->after('cache_creation_input_tokens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coaching_sessions', function (Blueprint $table) {
            $table->dropColumn(['cache_creation_input_tokens', 'cache_read_input_tokens']);
        });
    }
};
