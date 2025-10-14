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
        Schema::create('letterheads', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userID');
            $table->string('main_institution')->nullable();
            $table->string('sub_institution')->nullable();
            $table->string('name')->nullable();
            $table->string('field')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('fax')->nullable();
            $table->string('pos')->nullable();
            $table->string('npsn')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('logo');
            $table->timestamps();

            $table->foreign('userID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letterheads');
    }
};
