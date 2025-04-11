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
        Schema::create('bendahara', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('nip');
            $table->year('school');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('kepsek', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('nip');
            $table->year('school');
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('penerima', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('nip');
            $table->year('school');
            $table->timestamps();
            $table->softDeletes();
        });
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
