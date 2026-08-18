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
            $table->string('invoice_num')->nullable()->change();
            $table->string('order_num')->nullable()->change();
            $table->string('note_num')->nullable()->change();
            $table->string('bast_num')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('invoice_num')->nullable(false)->change();
            $table->string('order_num')->nullable(false)->change();
            $table->string('note_num')->nullable(false)->change();
            $table->string('bast_num')->nullable(false)->change();
        });
    }
};
