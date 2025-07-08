<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\TReportTab;
use App\Models\TReportTransactionTab;
use App\Models\TReportDocumentOutputTab;

class BidangController extends Controller
{
    /**
     * Dashboard Bidang/Satker
     */
    public function dashboard()
    {
        $userId = auth()->id();

        $totalApproved = TReportTransactionTab::where('user_id', $userId)
            ->where('status_ref', 4)
            ->where('status_active', 1)
            ->count();

        $totalPending = TReportTransactionTab::where('status_ref', 3)
            ->where('status_active', 1)
            ->count();

        $reports = TReportTab::with(['user.details', 'documents', 'transactions.status'])
            ->whereHas('transactions', function($q) {
                $q->where('status_ref', 3)
                  ->where('status_active', 1);
            })
            ->latest()
            ->paginate(10);

        return view('bidang.dashboard', compact('totalApproved', 'totalPending', 'reports'));
    }

    /**
     * Profil Bidang/Satker
     */
    public function profile()
    {
        $user    = auth()->user();
        $details = $user->details;
        return view('bidang.profile', compact('user', 'details'));
    }

    /**
     * Update profil Bidang/Satker
     */
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:user_tab,email,'.auth()->id(),
            'number_identification'  => 'required|string',
            'number_phone'           => 'required|string',
            'address'                => 'required|string',
            'working'                => 'nullable|string',
            'address_office'         => 'nullable|string',
        ]);

        $user = auth()->user();
        $user->update(['name'=>$data['name'], 'email'=>$data['email']]);
        $user->details()->updateOrCreate(
            ['user_tab_id'=> $user->id],
            [
                'number_identification'=> $data['number_identification'],
                'number_phone'         => $data['number_phone'],
                'address'              => $data['address'],
                'working'              => $data['working'] ?? null,
                'address_office'       => $data['address_office'] ?? null,
            ]
        );

        return back()->with('success','Profil berhasil diperbarui.');
    }

    /**
     * Daftar pengaduan menunggu telaah
     */
    public function pengaduanIndex()
    {
        $reports = TReportTab::with(['user.details', 'documents', 'transactions.status'])
            ->whereHas('transactions', function($q) {
                $q->where('status_ref', 3)
                  ->where('status_active', 1);
            })
            ->latest()
            ->paginate(10);

        return view('bidang.pengaduan.index', compact('reports'));
    }

    /**
     * Form telaah pengaduan
     */
    public function pengaduanEdit(TReportTab $report)
    {
        $report->load(['user.details', 'documents', 'transactions.status']);
        return view('bidang.pengaduan.edit', compact('report'));
    }

    /**
     * Proses telaah dan kirim ke Kepala BBWS
     */
    public function pengaduanUpdate(Request $request, TReportTab $report)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'file'  => 'nullable|file|max:4096',
        ]);

        DB::transaction(function() use ($request, $report) {
            TReportTransactionTab::where('t_report_tab_id', $report->id)
                ->update(['status_active'=>0]);

            if ($request->hasFile('file')) {
                $original = $request->file('file')->getClientOriginalName();
                $filename = time().'_'.$original;
                $path = $request->file('file')
                               ->storeAs("dokumen_telaah/{$report->number_registration}", $filename);
                TReportDocumentOutputTab::create([
                    't_report_tab_id'=> $report->id,
                    'filename'       => $path,
                ]);
            }

            TReportTransactionTab::create([
                't_report_tab_id'=> $report->id,
                'user_id'        => auth()->id(),
                'status_ref'     => 4,
                'status_active'  => 1,
                'm_status_tab_id'=> 2, // Diproses
                'notes'          => $request->notes,
                'approve_dates'  => now(),
            ]);
        });

        return redirect()->route('bidang.pengaduan.index')
                         ->with('success','Pengaduan berhasil ditelaah dan diteruskan.');
    }

    /**
     * Riwayat transaksi telaah Bidang
     */
    public function history()
    {
        $transactions = TReportTransactionTab::with(['report','status','officer'])
                          ->where('user_id', auth()->id())
                          ->orderBy('approve_dates','desc')
                          ->paginate(20);

        return view('bidang.history.index', compact('transactions'));
    }
}
