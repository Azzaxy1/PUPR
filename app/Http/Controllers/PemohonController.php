<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CodeController;
use App\Models\TReportTab;
use App\Models\TReportDocumentTab;
use App\Models\TReportTransactionTab;
use PDF;

class PemohonController extends Controller
{
    // Tampilkan dashboard pengaduan dengan ringkasan statistik
    public function dashboard()
    {
        $userId = auth()->id();
        $totalAll      = TReportTab::where('user_id', $userId)->count();
        $totalFinished = TReportTransactionTab::whereHas('report', fn($q) => $q->where('user_id', $userId))
            ->where('m_status_tab_id', 4) // Selesai
            ->count();

        $reports = TReportTab::where('user_id', $userId)
                    ->latest()
                    ->paginate(10);

        return view('pemohon.dashboard', compact('totalAll', 'totalFinished', 'reports'));
    }

    // Tampilkan form buat pengaduan dengan preview kode terbaru
    public function showCreate()
    {
        // Ambil konfigurasi kode
        $mCode = DB::table('m_code_tab')->first();
        $currentYear = now()->year;
        if ($mCode->year != $currentYear) {
            $nextCounter = 1;
        } else {
            $nextCounter = $mCode->start + 1;
        }
        $sequence = str_pad($nextCounter, $mCode->length, '0', STR_PAD_LEFT);
        $nextCode = $mCode->prefix . $currentYear . $sequence;

        return view('pemohon.pengaduan-create', compact('nextCode'));
    }

    // Simpan pengaduan baru
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'report'         => 'required|string',
            'documents'      => 'required|array',
            'documents.*'    => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 2. Generate kode laporan (sesuai implementasi Anda di CodeController)
            $code = app(CodeController::class)->generateReportCode();

            // 3. Simpan entri pengaduan
            $report = TReportTab::create([
                'user_id'             => auth()->id(),
                'number_registration' => $code,
                'report'              => $request->report,
            ]);

            // 4. Simpan tiap file pendukung
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $file) {
                    // pakai disk default (storage/app/dokumen_pengaduan)
                    $path = $file->store('dokumen_pengaduan');

                    TReportDocumentTab::create([
                        't_report_tab_id' => $report->id,
                        'filename'        => $path,
                    ]);
                }
            }

            // 5. Entry transaksi awal
            TReportTransactionTab::create([
                't_report_tab_id' => $report->id,
                'user_id'         => auth()->id(),
                'status_ref'      => 1,
                'status_active'   => 0,
                'm_status_tab_id' => 1,
                'approve_dates'   => now(),
            ]);

            DB::commit();
            return redirect()
                ->route('pemohon.dashboard')
                ->with('success', 'Pengaduan berhasil dibuat.');

        } catch (\Throwable $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    // Tampilkan detail pengaduan pemohon
    public function detail($id)
    {
        $report = TReportTab::with(['documents', 'transactions.status', 'documentOutputs'])
                    ->findOrFail($id);
        return view('pemohon.pengaduan-detail', compact('report'));
    }

    // Download PDF pengaduan hanya jika sudah selesai
    public function downloadPdf($id)
    {
        $report = TReportTab::with(['transactions.status', 'documentOutputs'])
                    ->findOrFail($id);
        $latest = $report->transactions->last();
        if ($latest->m_status_tab_id != 4) {
            abort(403, 'Pengaduan belum selesai.');
        }

        $pdf = PDF::loadView('pemohon.pengaduan-detail-pdf', compact('report'));
        return $pdf->download("pengaduan-{$report->number_registration}.pdf");
    }

    // Tampilkan halaman profil
    public function profile()
    {
        $user    = auth()->user();
        $details = $user->details;
        return view('pemohon.profile', compact('user', 'details'));
    }

    // Update atau simpan profil
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'number_identification' => 'required|string',
            'number_phone'          => 'required|string',
            'address'               => 'required|string',
            'working'               => 'nullable|string',
            'address_office'        => 'nullable|string',
        ]);

        auth()->user()->details()->updateOrCreate(
            ['user_tab_id' => auth()->id()],
            $data
        );

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}