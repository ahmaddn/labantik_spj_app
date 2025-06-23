<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan_barang extends Model
{
    protected $table = 'pesanan_barang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'barangID',
        'pesananID',
        'amount_accepted'
    ];
}
