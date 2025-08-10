<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kepsek extends Model
{
    use SoftDeletes;
    protected $table = 'kepsek';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'nip',
        'school',
        'year',
        'address',
        'userID'
    ];
}
