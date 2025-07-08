<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TReportTab;
use App\Models\TReportTransactionTab;

class PetugasController extends Controller
{
    /**
     * Dashboard Petugas Layanan
     */
    public function dashboard()
    {
        $totalReports  = TReportTab::count();
        $totalFinished = TReportTransactionTab::where('m_status_tab_id', 4)
                          ->where('status_active', 1)
                          ->count();
        $totalPemohon  = User::where('m_role_tab_id', 1)->count();

        $reports = TReportTab::with('user.details', 'transactions.status')
                    ->latest()
                    ->paginate(10);

        return view('petugas.dashboard', compact(
            'totalReports',
            'totalFinished',
            'totalPemohon',
            'reports'
        ));
    }

    /**
     * Tampilkan profil Petugas Layanan
     */
    public function profile()
    {
        $user    = auth()->user();
        $details = $user->details;
        return view('petugas.profile', compact('user', 'details'));
    }

    /**
     * Update profil Petugas Layanan
     */
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:user_tab,email,' . auth()->id(),
            'number_identification'  => 'required|string',
            'number_phone'           => 'required|string',
            'address'                => 'required|string',
            'working'                => 'nullable|string',
            'address_office'         => 'nullable|string',
        ]);

        auth()->user()->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        auth()->user()->details()->updateOrCreate(
            ['user_tab_id' => auth()->id()],
            [
                'number_identification' => $data['number_identification'],
                'number_phone'          => $data['number_phone'],
                'address'               => $data['address'],
                'working'               => $data['working'] ?? null,
                'address_office'        => $data['address_office'] ?? null,
            ]
        );

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Daftar pengguna
     */
    public function usersIndex()
    {
        $users = User::with('details', 'role')->paginate(10);
        return view('petugas.manageusers.index', compact('users'));
    }

    /**
     * Form create user
     */
    public function createUser()
    {
        return view('petugas.manageusers.create');
    }

    /**
     * Simpan user baru
     */
    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:user_tab,email',
            'm_role_tab_id'          => 'required|exists:m_role_tab,id',
            'number_identification'  => 'required|string',
            'number_phone'           => 'required|string',
            'address'                => 'required|string',
            'working'                => 'nullable|string',
            'address_office'         => 'nullable|string',
            'password'               => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'm_role_tab_id' => $data['m_role_tab_id'],
            'password'      => bcrypt($data['password']),
            'is_active'     => true,
        ]);

        $user->details()->create([
            'user_tab_id'            => $user->id,
            'number_identification'  => $data['number_identification'],
            'number_phone'           => $data['number_phone'],
            'address'                => $data['address'],
            'working'                => $data['working'] ?? null,
            'address_office'         => $data['address_office'] ?? null,
        ]);

        return redirect()->route('petugas.users.index')
                         ->with('success', 'Pengguna baru berhasil dibuat.');
    }

    /**
     * Form edit user
     */
    public function editUser($id)
    {
        $user = User::with('details', 'role')->findOrFail($id);
        return view('petugas.manageusers.edit', compact('user'));
    }

    /**
     * Update data pengguna
     */
    public function updateUser(Request $request, $id)
    {
        $data = $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:user_tab,email,' . $id,
            'm_role_tab_id'          => 'required|exists:m_role_tab,id',
            'number_identification'  => 'required|string',
            'number_phone'           => 'required|string',
            'address'                => 'required|string',
            'working'                => 'nullable|string',
            'address_office'         => 'nullable|string',
            'password'               => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'm_role_tab_id' => $data['m_role_tab_id'],
            'password'      => $data['password']
                                ? bcrypt($data['password'])
                                : $user->password,
        ]);

        $user->details()->updateOrCreate(
            ['user_tab_id' => $id],
            [
                'number_identification' => $data['number_identification'],
                'number_phone'          => $data['number_phone'],
                'address'               => $data['address'],
                'working'               => $data['working'] ?? null,
                'address_office'        => $data['address_office'] ?? null,
            ]
        );

        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Hapus pengguna
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->details()->delete();
        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Daftar pengaduan untuk diverifikasi
     */
    public function pengaduanIndex()
    {
        $reports = TReportTab::with(['user', 'transactions.status', 'documents', 'documentOutputs'])
            ->latest()
            ->paginate(10);

        return view('petugas.pengaduan.index', compact('reports'));
    }

    /**
     * Form verifikasi pengaduan
     */
    public function pengaduanEdit($id)
    {
        $report = TReportTab::with('user.details', 'documents', 'transactions.status')
                  ->findOrFail($id);

        return view('petugas.pengaduan.edit', compact('report'));
    }

    /**
     * Proses verifikasi (approve/reject)
     */
    public function pengaduanUpdate(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $id) {
            // Nonaktifkan status sebelumnya
            TReportTransactionTab::where('t_report_tab_id', $id)
                ->update(['status_active' => 0]);

            // Buat entri transaksi baru
            TReportTransactionTab::create([
                't_report_tab_id' => $id,
                'user_id'         => auth()->id(),
                'status_ref'      => 2,
                'status_active'   => 1,
                'm_status_tab_id' => $request->action === 'approve' ? 2 : 3,
                'notes'           => $request->notes,
                'approve_dates'   => now(),
            ]);
        });

        return redirect()->route('petugas.pengaduan.index')
                         ->with('success', 'Pengaduan berhasil ' . ($request->action === 'approve' ? 'diproses' : 'ditolak') . '.');
    }

    /**
     * Daftar pengaduan selesai
     */
    public function final()
    {
        $finalReports = TReportTab::whereHas('transactions', function ($q) {
                            $q->where('m_status_tab_id', 4)
                              ->where('status_active', 1);
                        })
                        ->with('user.details', 'documentOutputs')
                        ->paginate(10);

        return view('petugas.final.index', compact('finalReports'));
    }

    /**
     * Download PDF dari laporan final
     */
    public function finalPdf($id)
    {
        $report = TReportTab::with('user.details', 'documentOutputs')
                  ->findOrFail($id);

        return view('petugas.final.final_pdf', compact('report'));
    }

    /**
     * Riwayat semua transaksi pengaduan
     */
    public function history()
    {
        $transactions = TReportTransactionTab::with(['report', 'status', 'officer.role'])
        ->where('status_ref', 2)           // langkah verifikasi Petugas Layanan
        ->where('status_active', 1)        // hanya transaksi aktif
        ->whereHas('officer.role', function($q) {
            $q->where('title', 'Petugas Layanan');
        })
        ->orderBy('approve_dates', 'desc')
        ->paginate(20);

        return view('petugas.history.index', compact('transactions'));
    }
}
