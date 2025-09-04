<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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

        if (Auth::attempt($credentials, $remember_me)) {
            $request->session()->regenerate();

            if ($remember_me) {
                cookie()->queue(cookie('remember_username', $request->username, 10080));
                cookie()->queue(cookie('remember_password', $request->password, 10080));
                return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
            }

            cookie()->queue(Cookie::forget('remember_username'));
            cookie()->queue(Cookie::forget('remember_password'));

            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        cookie()->queue(Cookie::forget('remember_username'));
        cookie()->queue(Cookie::forget('remember_password'));

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
