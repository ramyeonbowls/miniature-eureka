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
        Schema::table('tclient', function (Blueprint $table) {
            $table->string('pos_pers_responsible', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tclient', function (Blueprint $table) {
            $table->dropColumn(['pos_pers_responsible']);
        });
    }
};
