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
        Schema::create('tmapping_book_titik_baca', function (Blueprint $table) {
            $table->string('client_id');
            $table->string('titik_baca');
            $table->string('book_id', 50);
            $table->integer('copy')->nullable();
            $table->timestamps();

            $table->primary(['client_id', 'titik_baca', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmapping_book_titik_baca');
    }
};
