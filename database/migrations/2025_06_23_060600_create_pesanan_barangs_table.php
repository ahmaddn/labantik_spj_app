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
        Schema::create('pesanan_barang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pesananID');
            $table->unsignedInteger('barangID');
            $table->string('condition')->nullable();
            $table->integer('amount_accepted')->nullable();

            $table->foreign('pesananID')->references('id')->on('pesanan');
            $table->foreign('barangID')->references('id')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_barangs');
    }
};
