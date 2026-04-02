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
        Schema::create('hm_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaksi_sewa_id');
            $table->date('tanggal_terakhir');
            $table->date('tanggal_sekarang');
            $table->integer('hm_terkahir');
            $table->integer('hm_sekarang');
            $table->timestamps();

            $table->foreign('transaksi_sewa_id')->references('id')->on('transaksi_sewas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hm_logs');
    }
};
