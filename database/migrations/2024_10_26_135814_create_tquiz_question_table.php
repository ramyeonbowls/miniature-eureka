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
        Schema::create('tquiz_question', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->string('survey_id', 50);
            $table->string('id', 50);
            $table->string('description', 255)->nullable();
            $table->string('seq', 5)->nullable();
            $table->string('required', 10)->nullable();
            $table->string('type', 10)->nullable();
            $table->float('point')->nullable();
            $table->datetime('created_at')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->datetime('updated_at')->nullable();
            $table->string('update_by', 50)->nullable();

			$table->primary(['client_id', 'survey_id', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tquiz_question');
    }
};
