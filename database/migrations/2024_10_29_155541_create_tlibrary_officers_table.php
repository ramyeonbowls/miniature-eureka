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
        Schema::create('tlibrary_officers', function (Blueprint $table) {
            $table->id();
            $table->string('client_id', 50);
            $table->string('name', 100);
            $table->string('nip', 50);
            $table->string('position', 100);
            $table->string('created_by', 100)->nullable();
            $table->datetime('created_at')->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tlibrary_officers');
    }
};
