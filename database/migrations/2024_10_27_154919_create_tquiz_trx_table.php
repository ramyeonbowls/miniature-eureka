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
        Schema::create('tquiz_trx', function (Blueprint $table) {
            $table->string('client_id', 50);
            $table->string('user_id', 50);
            $table->string('survey_id', 50);
            $table->string('question_id', 50);
            $table->string('answer_id', 50);
            $table->string('type', 50);
            $table->float('point')->nullable();
            $table->timestamps();

			$table->primary(['client_id', 'user_id', 'survey_id', 'question_id', 'answer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tquiz_trx');
    }
};
