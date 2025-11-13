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
        Schema::create('client_subsidies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('granted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('max_price'); // سقف خرید نفر, 0-5,000,000
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_subsidies');
    }
};
