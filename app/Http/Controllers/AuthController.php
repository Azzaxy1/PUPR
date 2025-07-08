<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Jika belum isi profil, arahkan ke halaman profil
            if (! $user->details()->exists()) {
                return redirect()->route('pemohon.profile')
                                 ->with('info', 'Silakan lengkapi profil Anda terlebih dahulu.');
            }

            // Jika sudah isi profil namun belum aktif, aktifkan akun
            if (! $user->is_active) {
                $user->update(['is_active' => 1]);
            }

            // Redirect berdasarkan role
            $role = $user->role->title;
            switch ($role) {
                case 'Pemohon':
                    $route = 'pemohon.dashboard';
                    break;
                case 'Petugas Layanan':
                    $route = 'petugas.dashboard';
                    break;
                case 'Ketua UKI':
                    $route = 'ketuauki.dashboard';
                    break;
                case 'Bidang/Satker/SNVT':
                    $route = 'bidang.dashboard';
                    break;
                case 'Kepala BBWS':
                    $route = 'kepalabbws.dashboard';
                    break;
                default:
                    $route = 'login';
            }

            return redirect()->intended(route($route));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Tampilkan form registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses registrasi baru
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:user_tab,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Buat akun dengan status is_active = 0 (belum aktif)
        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => bcrypt($data['password']),
            'm_role_tab_id' => 1, // Pemohon
            'is_active'     => 0,
        ]);

        // Login langsung dan arahkan ke profil
        Auth::login($user);
        return redirect()->route('pemohon.profile')
                         ->with('info', 'Silakan lengkapi profil Anda.');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}