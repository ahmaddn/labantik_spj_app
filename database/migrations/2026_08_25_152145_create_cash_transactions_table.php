<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('type'); // 'pemasukan' or 'pengeluaran'
            $table->date('date');
            $table->string('category');
            $table->integer('nominal');
            $table->integer('qty');
            $table->string('pic');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Copy data from expenditures to cash_transactions
        if (Schema::hasTable('expenditures')) {
            $expenditures = DB::table('expenditures')->get();
            foreach ($expenditures as $exp) {
                DB::table('cash_transactions')->insert([
                    'user_id' => $exp->user_id,
                    'type' => 'pengeluaran',
                    'date' => $exp->date,
                    'category' => $exp->type,
                    'nominal' => $exp->nominal,
                    'qty' => $exp->qty,
                    'pic' => $exp->pic,
                    'created_at' => $exp->created_at,
                    'updated_at' => $exp->updated_at,
                    'deleted_at' => $exp->deleted_at,
                ]);
            }

            // Drop expenditures table
            Schema::dropIfExists('expenditures');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate expenditures table and copy back data if needed
        Schema::create('expenditures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->date('date');
            $table->string('type');
            $table->integer('nominal');
            $table->integer('qty');
            $table->string('pic');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        if (Schema::hasTable('cash_transactions')) {
            $cashTransactions = DB::table('cash_transactions')->where('type', 'pengeluaran')->get();
            foreach ($cashTransactions as $ct) {
                DB::table('expenditures')->insert([
                    'user_id' => $ct->user_id,
                    'date' => $ct->date,
                    'type' => $ct->category,
                    'nominal' => $ct->nominal,
                    'qty' => $ct->qty,
                    'pic' => $ct->pic,
                    'created_at' => $ct->created_at,
                    'updated_at' => $ct->updated_at,
                    'deleted_at' => $ct->deleted_at,
                ]);
            }
            Schema::dropIfExists('cash_transactions');
        }
    }
};
