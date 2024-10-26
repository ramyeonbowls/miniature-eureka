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
        Schema::create('tquiz_h', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->string('id', 50);
            $table->string('title', 255);
            $table->date('start_date');
            $table->date('end_date');
            $table->datetime('created_at')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->datetime('updated_at')->nullable();
            $table->string('update_by', 50)->nullable();

			$table->primary(['client_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tquiz_h');
    }
};
