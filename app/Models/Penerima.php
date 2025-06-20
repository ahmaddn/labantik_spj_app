<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    //
    protected $table = 'penerima';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'nip',
        'school',
    ];
}
