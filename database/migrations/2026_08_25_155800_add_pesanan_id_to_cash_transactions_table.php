<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cash_transactions', function (Blueprint $table) {
            $table->unsignedInteger('pesanan_id')->nullable()->after('pic');
            
            $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
        });

        // Copy existing profits from pesanan table to cash_transactions automatically
        $pesanan = DB::table('pesanan')
            ->leftJoin('kegiatan', 'pesanan.kegiatanID', '=', 'kegiatan.id')
            ->select('pesanan.id', 'pesanan.userID', 'pesanan.order_date', 'pesanan.profit', 'pesanan.pic', 'kegiatan.name as kegiatan_name')
            ->where('pesanan.profit', '>', 0)
            ->get();

        foreach ($pesanan as $p) {
            DB::table('cash_transactions')->updateOrInsert(
                ['pesanan_id' => $p->id],
                [
                    'user_id' => $p->userID,
                    'type' => 'pemasukan',
                    'date' => $p->order_date,
                    'category' => 'Keuntungan Pesanan: ' . ($p->kegiatan_name ?? 'Proyek'),
                    'qty' => 1,
                    'nominal' => $p->profit,
                    'pic' => $p->pic ?? '-',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }

    public function down(): void
    {
        Schema::table('cash_transactions', function (Blueprint $table) {
            $table->dropForeign(['pesanan_id']);
            $table->dropColumn('pesanan_id');
        });
    }
};
