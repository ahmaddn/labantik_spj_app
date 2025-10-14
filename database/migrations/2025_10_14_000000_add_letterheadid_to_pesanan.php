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
            if (!Schema::hasColumn('pesanan', 'letterheadID')) {
                $table->unsignedBigInteger('letterheadID')->nullable()->after('kepsekID');
                $table->foreign('letterheadID')->references('id')->on('letterheads')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            if (Schema::hasColumn('pesanan', 'letterheadID')) {
                $table->dropForeign(['letterheadID']);
                $table->dropColumn('letterheadID');
            }
        });
    }
};
