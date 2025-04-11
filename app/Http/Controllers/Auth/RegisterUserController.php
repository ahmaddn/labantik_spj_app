<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class RegisterUserController extends Controller
{
    //
    public function create()
    {
        return view('auth.Register');
    }
    // fungsi untuk input data ke database 
    public function store(Request $request)
    {
        // Validasi input 
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'namalengkap' => ['required', 'string', 'max:255',],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);
        // Simpan user ke database 
        $user = User::create([
            'username' => $request->username,
            'namalengkap' => $request->namalengkap,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
        // Redirect ke dashboard atau halaman utama 
        return redirect()->route('login')->with('success', 'Registrasi berhasil!');
    }
}
