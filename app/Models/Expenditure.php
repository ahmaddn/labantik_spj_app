<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenditure extends Model
{
    use SoftDeletes;

    protected $table = 'expenditures';

    protected $fillable = [
        'user_id',
        'date',
        'type',
        'qty',
        'nominal',
        'pic',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'date' => 'date',
        'created_at' => 'datetime',
    ];
}
