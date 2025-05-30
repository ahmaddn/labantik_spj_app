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
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('kegiatan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('order');
            $table->date('accepted');
            $table->time('completed');
            $table->string('info');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('penyedia', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company');
            $table->integer('npwp');
            $table->string('address');
            $table->integer('account');
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
            $table->integer('money_total');
            $table->string('money');
            $table->date('order');
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
        Schema::table('barang', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('kegiatan', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('penyedia', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('penyedia', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('barang');
        Schema::dropIfExists('kegiatan');
        Schema::dropIfExists('penyedia');
        Schema::dropIfExists('pesanan');

    }

};
