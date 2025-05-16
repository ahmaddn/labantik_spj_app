<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kepsek extends Model
{
    protected $table = 'kepsek';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'nip',
        'school',
        'address',
        
    ];
}
