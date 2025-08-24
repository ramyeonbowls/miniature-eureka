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
        Schema::create('ttrx_read_titik_baca', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('uuid')->nullable();
            $table->string('client_id', 100)->nullable();
            $table->string('isbn', 50)->nullable();
            $table->dateTime('start_read')->nullable();
            $table->dateTime('end_read')->nullable();
            $table->string('book_id', 50)->nullable();
            $table->string('flag_end', 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ttrx_read_titik_baca');
    }
};
