<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $remember_me = $request->has('remember_me');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if ($remember_me) {
                cookie()->queue(cookie('remember_username', $request->username, 43200));
                cookie()->queue(cookie('remember_password', $request->password, 43200));
            }

            return redirect()->route('dashboard')->with('message', 'Login berhasil!');
        }

        return back()->withErrors(['username' => 'Username atau Password Salah!'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil Logout!');
    }
}
