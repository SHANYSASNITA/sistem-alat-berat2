<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pricing_alats', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn(['jenis_pekerjaan', 'harga_per_hari', 'harga_per_jam']);
            
            // Tambah kolom baru untuk 2 layanan
            $table->integer('harga_baket')->nullable()->after('alat_berat_id');
            $table->integer('harga_breker')->nullable()->after('harga_baket');
        });
    }

    public function down()
    {
        Schema::table('pricing_alats', function (Blueprint $table) {
            $table->string('jenis_pekerjaan')->nullable();
            $table->integer('harga_per_hari')->nullable();
            $table->integer('harga_per_jam')->nullable();
            
            $table->dropColumn(['harga_baket', 'harga_breker']);
        });
    }
};