<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Cek dulu apakah kolom sudah ada (untuk menghindari error Duplicate Column)
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('penyewa')->after('password'); 
        }
        
        if (!Schema::hasColumn('users', 'pelanggan_id')) {
            // UBAH KE STRING(36) agar bisa menampung UUID
            $table->string('pelanggan_id', 36)->nullable()->after('role');
        }
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        // Hapus kolom jika migrasi di-rollback
        $table->dropColumn(['role', 'pelanggan_id']);
    });
}
};
