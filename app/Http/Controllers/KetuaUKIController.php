<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TReportTab;
use App\Models\TReportTransactionTab;

class KetuaUkiController extends Controller
{
    /** Dashboard Ketua UKI */
    public function dashboard()
    {
        $userId = auth()->id();

        // Laporan yang sudah diproses oleh Ketua UKI (status_ref=3)
        $totalApproved = TReportTransactionTab::where('user_id', $userId)
            ->where('status_ref', 3)
            ->where('status_active', 1)
            ->count();

        // Laporan yang menunggu disposisi Ketua UKI (status_ref=2)
        $totalPending = TReportTransactionTab::where('status_ref', 2)
            ->where('status_active', 1)
            ->count();

        $reports = TReportTab::with(['user.details', 'documents', 'transactions.status'])
            ->whereHas('transactions', function($q) {
                $q->where('status_ref', 2)
                  ->where('status_active', 1);
            })
            ->latest()
            ->paginate(10);

        return view('ketuauki.dashboard', compact(
            'totalApproved', 'totalPending', 'reports'
        ));
    }

    /** Form profil Ketua UKI */
    public function profile()
    {
        $user    = auth()->user();
        $details = $user->details;
        return view('ketuauki.profile', compact('user', 'details'));
    }

    /** Update profil Ketua UKI */
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:user_tab,email,'.auth()->id(),
            'number_identification' => 'required|string',
            'number_phone'          => 'required|string',
            'address'               => 'required|string',
            'working'               => 'nullable|string',
            'address_office'        => 'nullable|string',
        ]);

        $user = auth()->user();
        $user->update([ 'name' => $data['name'], 'email' => $data['email'] ]);
        $user->details()->updateOrCreate(
            ['user_tab_id' => $user->id],
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

    /** Daftar pengaduan menunggu verifikasi oleh Ketua UKI */
    public function pengaduanIndex()
    {
        $reports = TReportTab::with(['user.details', 'documents', 'transactions.status'])
            ->whereHas('transactions', function($q) {
                $q->where('status_ref', 2)
                  ->where('status_active', 1);
            })
            ->latest()
            ->paginate(10);

        return view('ketuauki.pengaduan.index', compact('reports'));
    }

    /** Form verifikasi pengaduan oleh Ketua UKI */
    public function pengaduanEdit($id)
    {
        $report = TReportTab::with(['user.details', 'documents', 'transactions.status'])
            ->findOrFail($id);

        return view('ketuauki.pengaduan.edit', compact('report'));
    }

    /** Proses approve/reject oleh Ketua UKI */
    public function pengaduanUpdate(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'notes'  => 'nullable|string',
        ]);

        DB::transaction(function() use($request, $id) {
            // Nonaktifkan transaksi lama
            TReportTransactionTab::where('t_report_tab_id', $id)
                ->update(['status_active' => 0]);

            // Buat transaksi baru dengan status_ref=3
            TReportTransactionTab::create([
                't_report_tab_id' => $id,
                'user_id'         => auth()->id(),
                'status_ref'      => 3,
                'status_active'   => 1,
                'm_status_tab_id' => $request->action === 'approve' ? 2 : 3,
                'notes'           => $request->notes,
                'approve_dates'   => now(),
            ]);
        });

        return redirect()->route('ketuauki.pengaduan.index')
                         ->with('success', 'Pengaduan berhasil ' . (
                              $request->action==='approve'? 'diproses':'ditolak'
                            ) . '.');
    }

    /** Riwayat transaksi Ketua UKI */
    public function history()
    {
        $transactions = TReportTransactionTab::with(['report', 'status', 'officer'])
            ->where('user_id', auth()->id())
            ->orderBy('approve_dates', 'desc')
            ->paginate(20);

        return view('ketuauki.history.index', compact('transactions'));
    }
}
