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
        Schema::disableForeignKeyConstraints();
        Schema::table('pesanan', function (Blueprint $table) {
            $table->unsignedInteger('kepsekID')->nullable()->change();
            $table->unsignedInteger('bendaharaID')->nullable()->change();
            $table->unsignedInteger('kegiatanID')->nullable()->change();
            
            $table->date('prey')->nullable()->change();
            $table->date('paid')->nullable()->change();
            $table->date('accepted')->nullable()->change();
            
            $table->string('pic')->nullable()->change();
            $table->string('order_num')->nullable()->change();
            $table->string('note_num')->nullable()->change();
            $table->string('bast_num')->nullable()->change();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->unsignedInteger('kepsekID')->nullable(false)->change();
            $table->unsignedInteger('bendaharaID')->nullable(false)->change();
            $table->unsignedInteger('kegiatanID')->nullable(false)->change();
            
            $table->date('prey')->nullable(false)->change();
            $table->date('paid')->nullable(false)->change();
            $table->date('accepted')->nullable(false)->change();
            
            $table->string('pic')->nullable(false)->change();
            $table->string('order_num')->nullable(false)->change();
            $table->string('note_num')->nullable(false)->change();
            $table->string('bast_num')->nullable(false)->change();
        });
    }
};
