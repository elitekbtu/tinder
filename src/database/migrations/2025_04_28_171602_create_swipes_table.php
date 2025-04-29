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
        Schema::create('swipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Кто свайпнул
            $table->foreignId('meme_id')->constrained(); // Какой мем
            $table->enum('action', ['like', 'dislike']); // Тип действия
            $table->timestamps();
            $table->unique(['user_id', 'meme_id']); // Чтобы нельзя было дважды свайпнуть один мем
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swipes');
    }
};
