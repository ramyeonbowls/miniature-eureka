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
        Schema::create('trekening_bank', function (Blueprint $table) {
            $table->string('sid', 100);
            $table->string('id', 100);
            $table->string('npwp', 100);
            $table->string('norek', 100);
            $table->string('bank', 100);
            $table->string('nama', 100);
            $table->string('kota', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by', 50)->default('');
            $table->timestamp('updated_at')->useCurrent();
            $table->string('updated_by', 50)->default('');

            $table->primary(['sid', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trekening_bank');
    }
};
