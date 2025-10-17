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
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_name')->nullable()->after('position');
            $table->string('business_type')->nullable()->after('business_name');
            $table->string('business_phone')->nullable()->after('business_type');
            $table->text('business_address')->nullable()->after('business_phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'business_name',
                'business_type',
                'business_phone',
                'business_address'
            ]);
        });
    }
};
