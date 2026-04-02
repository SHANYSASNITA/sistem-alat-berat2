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
        Schema::create('pelanggans', function (Blueprint $table) {
            // Gunakan uuid karena Model Pelanggan Anda menggunakan UUID
            $table->uuid('id')->primary(); 
            
            $table->string('nama');
            $table->string('kontak', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama')->nullable();
            $table->text('tempat_tinggal');
            $table->string('ktp_pelanggan')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
