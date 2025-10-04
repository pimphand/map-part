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
        Schema::create('data_maps', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->comment('Title of the map data');
            $table->json('data')->default('{}')->comment('Data of the map');
            $table->string('status')->nullable()->comment('Status of the map data');
            $table->string('gambar')->nullable()->comment('Image of the map data');
            $table->string('lat')->comment('Latitude of the map data');
            $table->string('lng')->comment('Longitude of the map data');
            $table->string('kategori')->nullable()->comment('Category of the map data');
            $table->string('keterangan')->nullable()->comment('Keterangan of the map data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_maps');
    }
};
