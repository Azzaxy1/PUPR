<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserDetailTab;

class AuthController extends Controller
{
    /**
     * Registrasi akun baru (role default: Pemohon).
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', 'unique:user_tab,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'password'      => Hash::make($validated['password']),
                'm_role_tab_id' => 1, // Pemohon
                'is_active'     => false,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Registrasi berhasil. Silakan login.',
                'user'    => $user->only(['id', 'name', 'email']),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Registrasi gagal.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login dan hasilkan token.
     * Aktifkan user otomatis jika profil sudah diisi.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        $user = Auth::user();
        $hasProfile = $user->details()->exists();

        if ($hasProfile && ! $user->is_active) {
            $user->update(['is_active' => true]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'user'  => [
                    'id'         => $user->id,
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'role_id'    => $user->m_role_tab_id,
                    'is_active'  => $user->is_active,
                ],
                'profile_required' => ! $hasProfile
            ]
        ]);
    }

    /**
     * Logout user: hapus token saat ini.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}
