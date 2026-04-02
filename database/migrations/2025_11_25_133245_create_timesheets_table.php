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
    Schema::create('timesheets', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('transaksi_sewa_id');
        $table->date('tanggal');
        
        $table->double('hm_awal')->default(0);
        $table->double('hm_akhir')->default(0);

        $table->integer('jam_baket')->default(0);
        $table->integer('jam_breker')->default(0);
        $table->timestamps();

        $table->foreign('transaksi_sewa_id')->references('id')->on('transaksi_sewas')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
