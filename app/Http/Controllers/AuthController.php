<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- LOGIN ---
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek status akun
            if (Auth::user()->is_active === false) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
            }

            // Pengalihan berdasarkan Role
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Jika Penulis/Contributor -> Diarahkan ke Halaman Utama (Home)
            if (Auth::user()->role === 'contributor') {
                return redirect()->intended(route('home'))->with('success', 'Selamat datang kembali!');
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang kamu masukkan salah.',
        ])->onlyInput('email');
    }

    // --- REGISTER (PENULIS BARU) ---
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Setiap pendaftar otomatis menjadi 'contributor'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'contributor',
            'is_active' => true,
        ]);

        // Otomatis login setelah pendaftar berhasil dibuat
        Auth::login($user);
        $request->session()->regenerate();

        // Setelah daftar, juga diarahkan ke Halaman Utama (Home)
        return redirect()->route('home')
            ->with('success', 'Selamat datang! Akun penulis berhasil dibuat.');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
