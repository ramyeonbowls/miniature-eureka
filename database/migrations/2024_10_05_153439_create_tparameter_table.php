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
        Schema::create('tparameter', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->string('name', 50);
            $table->string('description');
            $table->string('value');
            $table->timestamps();

            $table->primary(['client_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tparameter');
    }
};
