<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TReportTab;
use App\Models\User;

class PemohonController extends Controller
{
    public function detailPengaduan($id)
    {
        try {
            $currentUser = Auth::user();
            
            // Ambil laporan dengan relasi yang diperlukan
            $report = TReportTab::with([
                'transactions' => function($query) {
                    $query->latest()
                        ->with(['status', 'officer.details'])
                        ->first();
                },
                'documents',
                'documentOutputs'
            ])->findOrFail($id);

            // Validasi kepemilikan laporan
            if ($report->user_id !== $currentUser->id) {
                return response()->json([
                    'message' => 'Akses ditolak. Pengaduan tidak ditemukan atau bukan milik anda.'
                ], 403);
            }

            // Ambil data user terpisah untuk handle relasi khusus
            $reportUser = User::with('details')->find($report->user_id);

            return response()->json([
                'message' => 'Detail pengaduan berhasil diambil',
                'data' => [
                    'pengaduan' => $this->formatPengaduan($report),
                    'profil_pengadu' => $this->formatProfil($reportUser),
                    'dokumen' => $this->formatDokumen($report)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil detail pengaduan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function formatPengaduan($report)
    {
        $latestTransaction = optional($report->transactions)->first();

        return [
            'id' => $report->id,
            'nomor_registrasi' => $report->number_registration,
            'isi_laporan' => $report->report,
            'tanggal_diajukan' => $report->created_at->format('d F Y H:i'),
            'status_terkini' => optional(optional($latestTransaction)->status)->title ?? 'Menunggu Verifikasi',
            'catatan_terakhir' => optional($latestTransaction)->notes ?? '-'
        ];
    }

    private function formatProfil($user)
    {
        return [
            'nama' => optional($user)->name ?? 'N/A',
            'email' => optional($user)->email ?? 'N/A',
            'detail' => [
                'nomor_identitas' => optional(optional($user)->details)->number_identification ?? '-',
                'alamat' => optional(optional($user)->details)->address ?? '-',
                'kontak' => optional(optional($user)->details)->number_phone ?? '-',
                'tempat_kerja' => optional(optional($user)->details)->working ?? '-'
            ]
        ];
    }

    private function formatDokumen($report)
    {
        return [
            'lampiran_pengadu' => $report->documents->map(function($doc) {
                return [
                    'nama_file' => basename($doc->filename),
                    'url' => asset('storage/'.$doc->filename),
                    'diupload_pada' => $doc->created_at->format('d/m/Y H:i')
                ];
            })->toArray(),
            
            'dokumen_hasil' => $report->documentOutputs->map(function($doc) {
                return [
                    'nama_file' => basename($doc->filename),
                    'url' => asset('storage/'.$doc->filename),
                    'diupload_pada' => $doc->created_at->format('d/m/Y H:i')
                ];
            })->toArray()
        ];
    }
}