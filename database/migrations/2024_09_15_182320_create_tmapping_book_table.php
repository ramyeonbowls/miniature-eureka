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
        Schema::create('tmapping_book', function (Blueprint $table) {
            $table->string('client_id');
            $table->string('isbn');
            $table->integer('copy')->nullable();
            $table->dateTime('create_date')->nullable();
            $table->primary(['client_id', 'isbn']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmapping_book');
    }
};
