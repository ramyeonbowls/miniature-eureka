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
        Schema::create('tread_fitur', function (Blueprint $table) {
            $table->id();
            $table->string('client_id', 50);
            $table->string('fitur', 5);
            $table->string('id_fitur', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tread_fitur');
    }
};
