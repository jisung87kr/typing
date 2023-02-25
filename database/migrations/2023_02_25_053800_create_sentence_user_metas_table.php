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
        Schema::create('sentence_user_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sentence_user_id');
            $table->string('alphabet')->nullable();
            $table->string('input')->nullable();
            $table->boolean('correct');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentence_user_metas');
    }
};
