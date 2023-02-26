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
        Schema::create('sentence_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sentence_id')->constrained();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('input');
            $table->integer('length');
            $table->integer('correct');
            $table->integer('wrong');
            $table->boolean('perfect');
            $table->timestamp('started_at');
            $table->timestamp('finished_at');
            $table->integer('wpm');
            $table->integer('usetime');
            $table->integer('difftime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sentence_users');
    }
};
