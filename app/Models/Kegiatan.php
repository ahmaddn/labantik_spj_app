<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    //
    protected $table = 'kegiatan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'order',
        'accepted',
        'completed',
        'info',
    ];
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'kegiatanID');
    }
}
