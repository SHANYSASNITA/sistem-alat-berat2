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
        Schema::create('operators', function (Blueprint $table) {
            // Primary key menggunakan UUID
            $table->uuid('id')->primary();
            
            // Kolom bawaan awal
            $table->string('nama');
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama')->nullable();
            $table->text('tempat_tinggal');
            $table->string('ktp_operator')->nullable(); // Menyimpan path foto/KTP
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
