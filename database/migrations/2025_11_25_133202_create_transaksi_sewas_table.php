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
        Schema::create('transaksi_sewas', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('alat_berat_id');
            $table->uuid('operator_id');
            $table->uuid('pelanggan_id');
            
            $table->string('jenis_sewa');
            $table->json('jenis_pekerjaan');
            $table->string('lokasi_proyek');
            $table->string('mobilisasi')->nullable();
            $table->string('demobilisasi')->nullable();
            $table->integer('biaya_modem')->default(0);

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();

            $table->integer('harga_sewa_baket')->nullable();
            $table->integer('harga_sewa_breker')->nullable();

            $table->enum('status', ['berjalan','selesai','batal'])->default('berjalan');

            $table->timestamps();

            $table->foreign('alat_berat_id')->references('id')->on('alat_berats')->onDelete('cascade');
            $table->foreign('operator_id')->references('id')->on('operators')->onDelete('cascade');
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_sewas');
    }
};
