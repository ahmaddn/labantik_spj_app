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
    protected $table='pesanan';
    protected $primaryKey='id';
    protected $fillable = [
            'invoice_num',
            'kegiatanID',
            'penyediaID',
            'penerimaID',
            'barangID',
            'BendaharaID',
            'budget',
            'paid'

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
        return $this->belongsTo(Barang::class, 'barangID', 'id');
    }
    public function bendahara()
    {
        return $this->belongsTo(Bendahara::class, 'BendaharaID', 'id');
    }

}
