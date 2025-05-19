<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyedia extends Model
{
    //
    protected $table = 'penyedia';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'company',
        'npwp',
        'address',
        'account',
        'delegation_name',
        'delegate_position',
        
    ];
}
