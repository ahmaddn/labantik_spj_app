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
        Schema::table('pesanan', function (Blueprint $table) {
            // Ubah kolom foreign key menjadi nullable
            $table->unsignedBigInteger('kegiatanID')->nullable()->change();
            $table->unsignedBigInteger('penyediaID')->nullable()->change();
            $table->unsignedBigInteger('penerimaID')->nullable()->change();
            $table->unsignedBigInteger('bendaharaID')->nullable()->change();
            $table->unsignedBigInteger('kepsekID')->nullable()->change();

            // Ubah kolom billing menjadi nullable jika belum
            $table->date('billing')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Kembalikan ke NOT NULL
            $table->unsignedBigInteger('kegiatanID')->nullable(false)->change();
            $table->unsignedBigInteger('penyediaID')->nullable(false)->change();
            $table->unsignedBigInteger('penerimaID')->nullable(false)->change();
            $table->unsignedBigInteger('bendaharaID')->nullable(false)->change();
            $table->unsignedBigInteger('kepsekID')->nullable(false)->change();
            $table->date('billing')->nullable(false)->change();
        });
    }
};
