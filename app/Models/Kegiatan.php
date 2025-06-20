<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use SoftDeletes;
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
