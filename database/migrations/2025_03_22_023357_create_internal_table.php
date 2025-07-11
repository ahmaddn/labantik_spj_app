<?php

use Database\Seeders\InternalSeeder;
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
        Schema::create('bendahara', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type', ['BOS', 'BOPD']);
            $table->bigInteger('nip');
            $table->unsignedInteger('userID');
            $table->softDeletes();

            $table->foreign('userID')->references('id')->on('users');
        });

        Schema::create('kepsek', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('nip');
            $table->string('school');
            $table->string('address');
            $table->unsignedInteger('userID');
            $table->softDeletes();

            $table->foreign('userID')->references('id')->on('users');
        });

        Schema::create('penerima', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('nip');
            $table->string('position');
            $table->unsignedInteger('userID');
            $table->softDeletes();

            $table->foreign('userID')->references('id')->on('users');
        });
        ((new InternalSeeder())->run());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bendahara');
        Schema::dropIfExists('kepsek');
        Schema::dropIfExists('penerima');
    }
};
