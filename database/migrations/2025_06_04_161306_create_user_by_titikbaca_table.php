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
        Schema::create('user_by_titikbaca', function (Blueprint $table) {
            $table->string('email', 50);
            $table->string('client_id', 50);
            $table->string('id', 50);

            $table->primary(['email', 'client_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_by_titikbaca');
    }
};
