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
        Schema::create('section_elements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('img_id')->nullable();
            $table->foreignId('section_type_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_elements', function (Blueprint $table) {
        $table->dropForeign(['section_type_id']); // drop FK first
    });
        Schema::dropIfExists('section_elements');
    }
};
