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
        Schema::create('tvisitors_offline', function (Blueprint $table) {
            $table->id();
            $table->string('client_id', 50);
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('nik', 50);
            $table->string('gender', 5);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tvisitors_offline');
    }
};
