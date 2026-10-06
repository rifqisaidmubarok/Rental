<?php

namespace App\Http\Controllers;

use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOGIN BERHASIL
        |--------------------------------------------------------------------------
        */

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            LoginLog::create([
                'user_id' => Auth::id(),
                'login_time' => now(),
                'ip_address' => $request->ip(),
                'status' => 'berhasil',
            ]);

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, Admin!');
            }

            if (Auth::user()->role === 'petugas') {
                return redirect()->route('petugas.dashboard')
                    ->with('success', 'Selamat datang, Petugas!');
            }

            Auth::logout();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Role pengguna tidak valid.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN GAGAL
        |--------------------------------------------------------------------------
        */

        LoginLog::create([
            'user_id' => null,
            'login_time' => now(),
            'ip_address' => $request->ip(),
            'status' => 'gagal',
        ]);

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}