<?php

namespace App\Http\Controllers\eksternal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        return view('eksternal.kegiatan.index');
    }
}
