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
    public $timestamps = false;

    protected $fillable = [
        'name',
        'order',
        'deadline',
        'info',
        'userID'
    ];
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'kegiatanID');
    }
}
