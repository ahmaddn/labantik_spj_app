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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID');
            $table->string('name');
            $table->date('order');
            $table->date('deadline');
            $table->string('info')->nullable();
            $table->softDeletes();

            $table->foreign('userID')->references('id')->on('users');
        });

        Schema::create('penyedia', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID');
            $table->string('company');
            $table->bigInteger('npwp');
            $table->string('address');
            $table->string('bank');
            $table->bigInteger('account');
            $table->string('delegation_name');
            $table->string('delegate_position');
            $table->softDeletes();

            $table->foreign('userID')->references('id')->on('users');
        });

        Schema::create('pesanan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID');
            $table->string('invoice_num');
            $table->string('order_num');
            $table->string('note_num');
            $table->string('bast_num');
            $table->integer('type_num');
            $table->integer('tax');
            $table->integer('shipping_cost');
            $table->unsignedInteger('kegiatanID');
            $table->unsignedInteger('penyediaID');
            $table->unsignedInteger('penerimaID');
            $table->unsignedInteger('bendaharaID');
            $table->date('paid');
            $table->date('billing')->nullable();
            $table->date('accepted');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('kegiatanID')->references('id')->on('kegiatan');
            $table->foreign('penyediaID')->references('id')->on('penyedia');
            $table->foreign('penerimaID')->references('id')->on('penerima');
            $table->foreign('bendaharaID')->references('id')->on('bendahara');
            $table->foreign('userID')->references('id')->on('users');
        });

        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pesananID');
            $table->unsignedInteger('userID');
            $table->string('name');
            $table->integer('amount');
            $table->integer('price');
            $table->integer('total');
            $table->string('unit');
            $table->softDeletes();

            $table->foreign('pesananID')->references('id')->on('pesanan');
            $table->foreign('userID')->references('id')->on('users');
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
