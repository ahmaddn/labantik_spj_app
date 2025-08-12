<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penerima;
use App\Models\Penyedia;
use App\Models\Kegiatan;
use App\Models\Barang;
use App\Models\Bendahara;

use Illuminate\Database\Eloquent\SoftDeletes;

class Pesanan extends Model
{
    use SoftDeletes;
    //
    protected $table = 'pesanan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'invoice_num',
        'order_num',
        'note_num',
        'bast_num',
        'type_num',
        'tax',
        'shipping_cost',
        'userID',
        'kegiatanID',
        'penyediaID',
        'penerimaID',
        'barangID',
        'bendaharaID',
        'kepsekID',
        'order_date',
        'prey',
        'paid',
        'status',
        'condition',
        'accepted',
        'billing'
    ];


    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatanID', 'id');
    }

    public function penyedia()
    {
        return $this->belongsTo(Penyedia::class, 'penyediaID', 'id');
    }

    public function penerima()
    {
        return $this->belongsTo(Penerima::class, 'penerimaID', 'id');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'pesananID', 'id');
    }
    public function bendahara()
    {
        return $this->belongsTo(Bendahara::class, 'bendaharaID', 'id');
    }

    public function kepsek()
    {
        return $this->belongsTo(Kepsek::class, 'kepsekID', 'id');
    }
}
