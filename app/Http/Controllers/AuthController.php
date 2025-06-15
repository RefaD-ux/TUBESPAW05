<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Tangani proses login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ], [
            'g-recaptcha-response.required' => 'Harap centang reCAPTCHA.',
            'g-recaptcha-response.captcha' => 'Verifikasi reCAPTCHA gagal, coba lagi.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('dashboard.admin'));
            } elseif (Auth::user()->role === 'pemilik') {
                return redirect()->intended(route('dashboard.pemilik'));
            } elseif (Auth::user()->role === 'pencari') {
                return redirect()->intended(route('dashboard.pencari'));
            }

            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    /**
     * Tampilkan form registrasi.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Tangani proses registrasi.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:pemilik,pencari'], // Pastikan role yang dipilih valid
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('welcome')->with('success', 'Registrasi berhasil! Silakan login.');

    }

    /**
     * Tangani proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

?>
