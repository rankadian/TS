<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
         if (Auth::guard('admin')->check() || Auth::guard('alumni')->check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);

    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
    ];

    // Coba login sebagai admin
    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json([
            'status' => true,
            'message' => 'Login berhasil sebagai admin.',
            'redirect' => route('admin.dashboard')
        ]);
    }

    // Coba login sebagai alumni
    if (Auth::guard('alumni')->attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json([
            'status' => true,
            'message' => 'Login berhasil sebagai alumni.',
            'redirect' => route('alumni.dashboard')
        ]);
    }

    // Jika gagal semua
    return response()->json([
        'status' => false,
        'message' => 'Email atau password salah.',
        'msgField' => [
            'email' => ['Email tidak ditemukan atau salah'],
            'password' => ['Password salah']
        ]
    ]);
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return redirect('login');
        return redirect('landing');
    }
}
