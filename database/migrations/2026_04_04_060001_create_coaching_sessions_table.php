<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coaching_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            $table->string('input_type');
            $table->text('raw_text')->nullable();
            $table->string('screenshot_path')->nullable();
            $table->text('situation_read')->nullable();
            $table->json('applicable_principles')->nullable();
            $table->json('reply_options')->nullable();
            $table->text('ai_raw_response')->nullable();
            $table->unsignedInteger('prompt_tokens')->nullable();
            $table->unsignedInteger('completion_tokens')->nullable();
            $table->timestamps();

            $table->index('contact_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coaching_sessions');
    }
};
