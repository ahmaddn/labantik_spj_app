<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penyedia extends Model
{
    use SoftDeletes;
    //
    protected $table = 'penyedia';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company',
        'npwp',
        'address',
        'bank',
        'account',
        'delegation_name',
        'delegate_position',
    ];
}
