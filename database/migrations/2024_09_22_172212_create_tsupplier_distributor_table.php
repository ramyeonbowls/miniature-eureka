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
        Schema::create('tsupplier_distributor', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('type', 1);
            $table->string('nama_perusahaan', 100); 
            $table->string('email_perusahaan', 100);
            $table->string('password', 10);
            $table->string('password_confirmation', 10);
            $table->string('negara', 50); 
            $table->string('provinsi', 50); 
            $table->string('kabupaten', 50); 
            $table->string('kecamatan', 50); 
            $table->string('keluarahan', 50); 
            $table->string('kode_pos', 20);
            $table->string('alamat', 150);
            $table->string('telepon', 20);
            $table->string('handphone', 20);
            $table->string('pimpinan', 50);
            $table->string('jabatan', 50);
            $table->string('hpimpinan', 50);
            $table->string('pic', 50);
            $table->string('hpic', 50);
            $table->string('file', 150);
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by', 50)->default('');
            $table->timestamp('updated_at')->useCurrent();
            $table->string('updated_by', 50)->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsupplier_distributor');
    }
};
