<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;
    //
     protected $table = 'barang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'amount',
        'price',
        'total'];
}
