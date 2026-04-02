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
        Schema::create('pricing_alats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('alat_berat_id');
            $table->enum('jenis_pekerjaan', ['baket','breker'])->default('baket');
            $table->integer('harga_per_hari')->nullable();
            $table->integer('harga_per_jam')->nullable();
            $table->date('berlaku_mulai');
            $table->date('berlaku_selesai')->nullable();
            $table->timestamps();

            $table->foreign('alat_berat_id')->references('id')->on('alat_berats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_alats');
    }
};
