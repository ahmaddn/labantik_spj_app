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
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('amount');
            $table->integer('price');
            $table->integer('total');
            $table->string('unit');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('kegiatan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('order');
            $table->date('accepted');
            $table->time('completed');
            $table->string('info')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('penyedia', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company');
            $table->bigInteger('npwp');
            $table->string('address');
            $table->bigInteger('account');
            $table->string('delegation_name');
            $table->string('delegate_position');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pesanan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_num');
            $table->unsignedInteger('kegiatanID');
            $table->unsignedInteger('penyediaID');
            $table->unsignedInteger('penerimaID');
            $table->unsignedInteger('barangID');
            $table->integer('budget');
            $table->date('paid');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kegiatanID')->references('id')->on('kegiatan');
            $table->foreign('penyediaID')->references('id')->on('penyedia');
            $table->foreign('penerimaID')->references('id')->on('penerima');
            $table->foreign('barangID')->references('id')->on('barang');

            $table->index('kegiatanID');
            $table->index('penyediaID');
            $table->index('penerimaID');
            $table->index('barangID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('kegiatan');
        Schema::dropIfExists('penyedia');
    }

};
