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
        Schema::create('meals', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->integer('calories')->nullable();
    $table->decimal('price', 10, 2);
    $table->boolean('is_vegan')->default(false);
    $table->string('kcal')->nullable();
    $table->json('nutritional_informations')->nullable();
    $table->json('contraindications')->nullable();
    $table->json('consumable_items')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
