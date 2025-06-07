<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard.index');
        }

        if (Auth::guard('alumni')->check()) {
            return redirect()->route('alumni.dashboard.index');
        }

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'status' => true,
                'message' => 'Successful login as admin.',
                'redirect' => route('admin.dashboard.index')
            ]);
        }

        if (Auth::guard('alumni')->attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'status' => true,
                'message' => 'Successful login as an alumnus.',
                'redirect' => route('alumni.dashboard.index')
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Incorrect email or password.',
            'msgField' => [
                'email' => ['Email not found or incorrect'],
                'password' => ['Incorrect password']
            ]
        ]);
    }


    public function logout(Request $request)
    {
        $guard = Auth::getDefaultDriver(); // fallback ke default ('web')

        // Jika alumni sedang login
        if (Auth::guard('alumni')->check()) {
            $guard = 'alumni';
        }

        // Jika admin sedang login
        if (Auth::guard('admin')->check()) {
            $guard = 'admin';
        }

        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
