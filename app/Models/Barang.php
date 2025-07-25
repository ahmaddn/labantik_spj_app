<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;
    //
    protected $table = 'barang';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'pesananID',
        'userID',
        'amount',
        'price',
        'total',
        'unit',
    ];

    public function pesanans()
    {
        return $this->belongsToMany(Pesanan::class, 'pesanan_barang', 'barangID', 'pesananID');
    }
}
