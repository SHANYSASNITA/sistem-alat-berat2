<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pricing_alats', function (Blueprint $table) {
            // Kita gunakan enum untuk 3 status. Default-nya 'ready'
            $table->enum('status', ['ready', 'in_use', 'maintenance'])->default('ready')->after('berlaku_selesai');
        });
    }

    public function down()
    {
        Schema::table('pricing_alats', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};