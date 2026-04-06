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
    Schema::create('web_profiles', function (Blueprint $table) {
        $table->id();
        // Section About
        $table->string('about_title')->nullable();
        $table->text('about_description')->nullable();
        $table->string('about_image')->nullable();
        
        // Section Service (Disesuaikan dengan Baket & Breker)
        $table->string('service_title_1')->default('Layanan Baket');
        $table->text('service_desc_1')->nullable();
        $table->string('service_title_2')->default('Layanan Breker');
        $table->text('service_desc_2')->nullable();
        
        $table->timestamps();
    });
}
};
