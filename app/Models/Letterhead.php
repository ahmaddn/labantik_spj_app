<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letterhead extends Model
{
    protected $fillable = [
        'userID',
        'main_institution',
        'sub_institution',
        'name',
        'address1',
        'address2',
        'field',
        'no_telp',
        'fax',
        'pos',
        'npsn',
        'website',
        'email',
        'logo',
    ];
}
