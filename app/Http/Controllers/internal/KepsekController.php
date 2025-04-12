<?php

namespace App\Http\Controllers\internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KepsekController extends Controller
{
    public function index()
    {
        return view('internal.kepsek.index');
    }
}
