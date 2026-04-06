<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Pastikan tabel dihapus dulu jika sisa-sisa lama masih ada
        Schema::dropIfExists('web_profiles');

        Schema::create('web_profiles', function (Blueprint $table) {
            $table->id();
            
            // Kolom untuk Section HERO
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image')->nullable(); // Ini kolom foto background hero

            // Kolom untuk Section ABOUT
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->string('about_image')->nullable(); // Ini kolom foto profil perusahaan

            // Kolom untuk Section SERVICES
            $table->string('service_title_1')->default('Layanan Baket');
            $table->text('service_desc_1')->nullable();
            $table->string('service_title_2')->default('Layanan Breker');
            $table->text('service_desc_2')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('web_profiles');
    }
};