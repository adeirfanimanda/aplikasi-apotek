<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $roles = Auth::user()->roles;
            if ($roles === 'admin') {
                return redirect()->intended('dashboard');
            } elseif ($roles === 'kasir') {
                return redirect()->intended('transactions');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
