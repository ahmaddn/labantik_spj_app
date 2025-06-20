<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bendahara extends Model
{
    //
    protected $table = 'bendahara';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'jenis',
        'nip',
        'school',

    ];
}
