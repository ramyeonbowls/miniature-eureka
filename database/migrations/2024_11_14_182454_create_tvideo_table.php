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
        Schema::create('tvideo', function (Blueprint $table) {
            $table->string('id', 50);
            $table->string('title', 100)->nullable();
            $table->text('description')->nullable();
            $table->text('file')->nullable();
            $table->string('flag_aktif', 1)->default('Y');
            $table->string('flag_platform', 1)->default('N');
            $table->string('client_id', 50);
            $table->datetime('created_at')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->datetime('updated_at')->nullable();
            $table->string('update_by', 50)->nullable();

            $table->primary(['id', 'client_id'], 'pk_tvideo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tvideo');
    }
};
