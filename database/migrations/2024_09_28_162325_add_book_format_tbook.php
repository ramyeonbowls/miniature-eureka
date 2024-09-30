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
        Schema::table('tbook', function (Blueprint $table) {
            $table->string('book_format_id', 25)->nullable();
            $table->integer('age')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbook', function (Blueprint $table) {
            $table->dropColumn(['book_format_id', 'age']);
        });
    }
};
