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
        Schema::create('tclient', function (Blueprint $table) {
            $table->string('client_id')->primary();
            $table->string('instansi_name')->nullable();
            $table->string('application_name')->nullable();
            $table->string('address')->nullable();
            $table->string('provinsi_id')->nullable();
            $table->string('kabupaten_id')->nullable();
            $table->string('kecamatan_id')->nullable();
            $table->string('kelurahan_id')->nullable();
            $table->string('npwp')->nullable();
            $table->string('pers_responsible')->nullable();
            $table->string('mou_sign_name')->nullable();
            $table->string('pos_sign_name')->nullable();
            $table->string('administrator_name')->nullable();
            $table->string('administrator_phone')->nullable();
            $table->string('logo')->nullable();
            $table->string('distributor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tclient');
    }
};
