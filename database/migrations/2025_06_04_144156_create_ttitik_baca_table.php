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
        Schema::create('ttitik_baca', function (Blueprint $table) {
            $table->string('id', 50);
            $table->string('client_id', 50);
            $table->string('name', 50);
            $table->timestamps();

            $table->primary(['id', 'client_id'], 'pk_ttitik_baca');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ttitik_baca');
    }
};
