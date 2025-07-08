<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TReportTab;
use App\Models\User;
use App\Models\TReportTransactionTab;
use App\Models\TReportDocumentOutputTab;

class KepalaBbwsController extends Controller
{
    /** Dashboard Kepala BBWS */
    public function dashboard()
    {
        $totalActive   = TReportTransactionTab::where('status_active', 1)
                            ->distinct('t_report_tab_id')
                            ->count('t_report_tab_id');
        $totalFinished = TReportTransactionTab::where('m_status_tab_id', 4)
                            ->where('status_active', 1)
                            ->count();
        $totalPemohon  = User::where('m_role_tab_id', 1)->count();
        $pending       = $totalActive - $totalFinished;

        return view('kepalabbws.dashboard', compact(
            'totalActive', 'totalFinished', 'totalPemohon', 'pending'
        ));
    }

    /** Form profil Kepala BBWS */
    public function profile()
    {
        $user    = auth()->user();
        $details = $user->details;

        return view('kepalabbws.profile', compact('user', 'details'));
    }

    /** Update profil Kepala BBWS */
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
        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

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

    /** Daftar pengaduan finalisasi (status_ref=4 & status_active=1) */
    public function pengaduanIndex()
    {
        $reports = TReportTab::with(['user.details','documents','transactions.status','documentOutputs'])
            ->whereHas('transactions', function($q) {
                $q->where('status_ref', 4)
                  ->where('status_active', 1);
            })
            ->latest()
            ->paginate(10);

        return view('kepalabbws.pengaduan.index', compact('reports'));
    }

    /** Form finalisasi & upload jawaban */
    public function pengaduanEdit(TReportTab $report)
    {
        $report->load(['user.details','documents','transactions.status','documentOutputs']);

        return view('kepalabbws.pengaduan.edit', compact('report'));
    }

    /** Proses finalisasi dan upload jawaban Kepala BBWS */
    public function pengaduanUpdate(Request $request, TReportTab $report)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'file'  => 'required|file|max:4096',
        ]);

        DB::transaction(function() use ($request, $report) {
            // nonaktifkan transaksi lama
            TReportTransactionTab::where('t_report_tab_id', $report->id)
                ->update(['status_active' => 0]);

            // upload file jawaban
            $original = $request->file('file')->getClientOriginalName();
            $filename = time().'_'.$original;
            $path     = $request->file('file')
                                ->storeAs("dokumen_jawaban/{$report->number_registration}", $filename);

            TReportDocumentOutputTab::create([
                't_report_tab_id' => $report->id,
                'filename'        => $path,
            ]);

            // buat entri finalisasi
            TReportTransactionTab::create([
                't_report_tab_id' => $report->id,
                'user_id'         => auth()->id(),
                'status_ref'      => 5,
                'status_active'   => 1,
                'm_status_tab_id' => 4,
                'notes'           => $request->notes,
                'approve_dates'   => now(),
            ]);
        });

        return redirect()->route('kepalabbws.pengaduan.index')
                         ->with('success', 'Pengaduan berhasil diselesaikan dan jawaban diunggah.');
    }

    /** Riwayat transaksi finalisasi Kepala BBWS */
    public function history()
    {
        $transactions = TReportTransactionTab::with(['report','status','officer'])
            ->where('user_id', auth()->id())
            ->orderBy('approve_dates','desc')
            ->paginate(20);

        return view('kepalabbws.history.index', compact('transactions'));
    }
}
