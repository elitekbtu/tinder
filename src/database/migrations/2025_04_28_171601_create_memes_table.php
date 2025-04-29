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
        Schema::create('memes', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');       // Ссылка на изображение
            $table->string('title')->nullable(); // Название мема
            $table->text('description')->nullable(); // Описание (для AI-анализа)
            $table->string('category')->nullable(); // Категория (например, "Коты", "Программисты")
            $table->foreignId('user_id')->nullable()->constrained(); // Автор мема (если есть)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memes');
    }
};
