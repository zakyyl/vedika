<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identity' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->identity,
            'password' => $request->password,
        ];

        if (Auth::guard('web')->attempt($credentials)) {
    $request->session()->regenerate();
    return redirect()->intended('/dashboard');
}


        return back()->withErrors([
            'identity' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
