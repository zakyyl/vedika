<?php

namespace App\Http\Controllers;

use App\Models\MliteUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:mlite_users,username',
            'fullname' => 'nullable|string',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = MliteUser::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'access' => 'dashboard',
        ]);

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
