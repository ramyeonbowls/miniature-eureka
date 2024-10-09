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
        Schema::create('tvisitors', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->date('date');
            $table->string('visitor');
            $table->string('platform')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_name')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->primary(['client_id', 'date', 'visitor'], 'PK_tvisitors');
            $table->unique(['client_id', 'date', 'visitor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tvisitors');
    }
};
