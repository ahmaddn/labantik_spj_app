<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penerima extends Model
{
    use SoftDeletes;
    //
    protected $table = 'penerima';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'nip',
        'school',
    ];
}
