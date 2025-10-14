<?php

use Database\Seeders\EksternalSeeder;
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
            $table->string('npwp')->nullable();
            $table->string('address');
            $table->string('post_code');
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
            $table->integer('tax')->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->integer('profit')->nullable();
            $table->integer('total')->nullable();
            $table->unsignedInteger('kegiatanID')->nullable();
            $table->unsignedInteger('penyediaID')->nullable();
            $table->unsignedInteger('penerimaID')->nullable();
            $table->unsignedInteger('bendaharaID')->nullable();
            $table->unsignedInteger('kepsekID')->nullable();
            $table->unsignedInteger('letterheadID')->nullable();
            $table->date('order_date');
            $table->date('prey');
            $table->date('paid');
            $table->date('billing')->nullable();
            $table->date('accepted');
            $table->string('pic');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('kegiatanID')->references('id')->on('kegiatan');
            $table->foreign('penyediaID')->references('id')->on('penyedia');
            $table->foreign('penerimaID')->references('id')->on('penerima');
            $table->foreign('bendaharaID')->references('id')->on('bendahara');
            $table->foreign('kepsekID')->references('id')->on('kepsek');
            $table->foreign('letterheadID')->references('id')->on('letterheads');
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
        ((new EksternalSeeder())->run());
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
