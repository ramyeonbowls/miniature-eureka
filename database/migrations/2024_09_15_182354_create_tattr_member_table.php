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
        Schema::create('tattr_member', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('client_id', 100);
            $table->string('nik', 25)->nullable();
            $table->string('phone', 20)->nullable();
            $table->date('birthday')->nullable();
            $table->string('photo', 100)->nullable();
            $table->primary(['id', 'client_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tattr_member');
    }
};
