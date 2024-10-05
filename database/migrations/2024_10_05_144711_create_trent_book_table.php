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
        Schema::create('trent_book', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->bigInteger('user_id');
            $table->string('book_id', 50);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('flag_end', 1)->default('N');
            $table->timestamps();

            $table->primary(['client_id', 'user_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trent_book');
    }
};
