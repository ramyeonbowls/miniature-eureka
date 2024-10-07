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
        Schema::table('trent_book', function (Blueprint $table) {
            $table->dropPrimary();
            $table->primary(['client_id', 'user_id', 'book_id', 'start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trent_book', function (Blueprint $table) {
            $table->dropPrimary();
            $table->primary(['client_id', 'user_id', 'book_id']);
        });
    }
};
