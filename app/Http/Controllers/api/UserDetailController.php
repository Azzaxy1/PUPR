<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDetailTab;

class UserDetailController extends Controller
{
    /**
     * Tampilkan data profil user yang login.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $detail = $user->details;

        return response()->json([
            'message' => $detail ? 'Data profil ditemukan' : 'Profil belum diisi',
            'data'    => $detail,
            'filled'  => $detail !== null,
        ]);
    }

    /**
     * Simpan data profil user (hanya jika belum ada).
     */
    public function store(Request $request)
    {
        $validated = $this->validateProfile($request);

        $user = $request->user();

        if ($user->details) {
            return response()->json([
                'message' => 'Profil sudah pernah disimpan. Gunakan endpoint update.',
            ], 409);
        }

        // Proses upload foto
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('foto_profil', 'public');
            $validated['photo'] = $path;
        }

        $user->details()->create($validated);

        if (! $user->is_active) {
            $user->update(['is_active' => true]);
        }

        return response()->json([
            'message' => 'Profil berhasil disimpan',
            'data'    => $user->details
        ]);
    }

    /**
     * Update data profil user (jika sudah ada).
     */
    public function update(Request $request)
    {
        $validated = $this->validateProfile($request);

        $user = $request->user();
        $detail = $user->details;

        if (! $detail) {
            return response()->json([
                'message' => 'Profil belum diisi. Gunakan endpoint store terlebih dahulu.'
            ], 404);
        }

        // Proses upload foto baru (hapus lama jika ada)
        if ($request->hasFile('photo')) {
            if ($detail->photo && Storage::disk('public')->exists($detail->photo)) {
                Storage::disk('public')->delete($detail->photo);
            }

            $path = $request->file('photo')->store('foto_profil', 'public');
            $validated['photo'] = $path;
        }

        $detail->update($validated);

        if (! $user->is_active) {
            $user->update(['is_active' => true]);
        }

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'data'    => $detail
        ]);
    }

    /**
     * Validasi input profil.
     */
    private function validateProfile(Request $request): array
    {
        return $request->validate([
            'number_identification' => ['required', 'string'],
            'number_phone'          => ['required', 'string'],
            'address'               => ['required', 'string'],
            'working'               => ['nullable', 'string'],
            'address_office'        => ['nullable', 'string'],
            'photo'                 => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);
    }
}
