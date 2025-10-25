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
    if (Schema::hasTable('section_elements')) {
        Schema::table('section_elements', function (Blueprint $table) {
            if (Schema::hasColumn('section_elements', 'section_type_id')) {
                $foreignKeys = \DB::select("SELECT CONSTRAINT_NAME
                                             FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                                             WHERE TABLE_NAME = 'section_elements'
                                             AND COLUMN_NAME = 'section_type_id'
                                             AND CONSTRAINT_SCHEMA = DATABASE()");
                foreach ($foreignKeys as $fk) {
                    $table->dropForeign([$fk->CONSTRAINT_NAME]);
                }
            }
        });

        Schema::dropIfExists('section_elements');
    }
}

};
