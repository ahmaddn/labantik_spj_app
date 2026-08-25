<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'cash_transactions';

    protected $fillable = [
        'user_id',
        'type', // 'pemasukan' or 'pengeluaran'
        'date',
        'category',
        'qty',
        'nominal',
        'pic',
        'pesanan_id',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];
}
