<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bendahara extends Model
{
    use SoftDeletes;
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
