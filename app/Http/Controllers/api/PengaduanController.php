<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\MStatusTab;
use App\Models\TReportTab;
use App\Models\TReportTransactionTab;
use App\Models\TReportDocumentTab;
use App\Models\TReportDocumentOutputTab;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Pemohon mengirim laporan pengaduan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'report' => 'required|string',
            'file'   => 'nullable|file|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $user = $request->user();

            // 1. Ambil kode dari endpoint API CodeController
            $response = app(\App\Http\Controllers\Api\CodeController::class)->generateReportCode();
            $kode = $response->original['code'];

            // 2. Ambil status ID dari m_status_tab
            $statusId = $this->getStatusId('Menunggu Verifikasi');

            // 3. Simpan laporan
            $report = TReportTab::create([
                'user_id'             => $user->id,
                'number_registration' => $kode,
                'report'              => $request->report,
            ]);

            // 4. Simpan file jika ada
            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('dokumen_pengaduan', 'public');
                TReportDocumentTab::create([
                    't_report_tab_id' => $report->id,
                    'filename' => $path,
                ]);
            }

            // 5. Simpan transaksi awal
            TReportTransactionTab::create([
                't_report_tab_id' => $report->id,
                'user_id'         => $user->id,
                'status_ref'      => 1,
                'status_active'   => 0,
                'm_status_tab_id' => $statusId,
                'notes'           => 'Laporan masuk dan menunggu verifikasi',
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Laporan berhasil dikirim.',
                'kode'    => $kode
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Semua role dapat melihat laporan pengaduan.
     */
    public function view()
    {
        $user = Auth::user();
        $role = $user->role->title;

        // Case 1: PEMOHON — hanya laporan sendiri
        if ($role === 'Pemohon') {
            $reports = TReportTab::with([
                    'documents',
                    'documentOutputs',
                    'transactions' => function ($q) {
                        // Menampilkan semua transaksi terkait laporan
                        $q->orderByDesc('id'); // Urutkan transaksi berdasarkan ID terbaru
                    }
                ])
                ->where('user_id', $user->id)
                ->latest()
                ->get()
                ->map(function ($report) {
                    $trx = $report->transactions; // Ambil semua transaksi terkait laporan

                    return [
                        'id'                  => $report->id,
                        'user_id'             => $report->user_id,
                        'number_registration' => $report->number_registration,
                        'report'              => $report->report,
                        'status_active'       => $trx->pluck('status_active'),
                        'm_status_tab_id'     => $trx->pluck('m_status_tab_id'),
                        'notes'               => $trx->pluck('notes'),
                        'approve_dates'       => $trx->pluck('approve_dates'),
                        'created_at'          => $report->created_at,
                        'updated_at'          => $report->updated_at,
                        'documents'           => $report->documents,
                        'document_outputs'    => $report->documentOutputs,
                    ];
                });

            return response()->json(['data' => $reports]);
        }

        // Case 2: PETUGAS LAYANAN — tampilkan laporan yang belum diapprove atau sudah diapprove
        if ($role === 'Petugas Layanan') {
            $reports = TReportTab::whereHas('transactions', function ($q) {
                    $q->whereIn('status_ref', [1, 2, 5])  // Status 1: Belum verifikasi, Status 2: Sudah diapprove, Status 5: Selesai
                    ->whereIn('status_active', [0, 1]);  // Status aktif 0 (menunggu) atau 1 (sudah aktif)
                })
                ->with([
                    'documents',
                    'documentOutputs',
                    'user',
                    'transactions' => function ($q) {
                        $q->orderByDesc('id');
                    }
                ])
                ->latest()
                ->get();

            return response()->json(['data' => $reports]);
        }

        // Case 3: KETUA UKI — tampilkan laporan yang sudah diapprove Petugas Layanan
        if ($role === 'Ketua UKI') {
            $reports = TReportTab::whereHas('transactions', function ($q) {
                    $q->where('status_ref', 2) // Status 2: Sudah di-approve oleh Petugas
                    ->where('status_active', 1); // Status aktif 1 (sudah aktif)
                })
                ->with([
                    'documents',
                    'documentOutputs',
                    'user',
                    'transactions' => function ($q) {
                        $q->orderByDesc('id');
                    }
                ])
                ->latest()
                ->get();

            return response()->json(['data' => $reports]);
        }

        // Case 4: BIDANG/SATKER/SNVT — tampilkan laporan yang sudah diapprove oleh Ketua UKI
        if ($role === 'Bidang/Satker/SNVT') {
            $reports = TReportTab::whereHas('transactions', function ($q) {
                    $q->where('status_ref', 3) // Status 3: Sudah di-approve oleh Ketua UKI
                    ->where('status_active', 1); // Status aktif 1 (sudah aktif)
                })
                ->with([
                    'documents',
                    'documentOutputs',
                    'user',
                    'transactions' => function ($q) {
                        $q->orderByDesc('id');
                    }
                ])
                ->latest()
                ->get();

            return response()->json(['data' => $reports]);
        }

        // Case 5: KEPALA BBWS — tampilkan laporan yang sudah ditelaah oleh Bidang/Satker/SNVT
        if ($role === 'Kepala BBWS') {
            $reports = TReportTab::whereHas('transactions', function ($q) {
                    $q->where('status_ref', 4) // Status 4: Sudah ditelaah oleh Bidang/Satker/SNVT
                    ->where('status_active', 1); // Status aktif 1 (sudah aktif)
                })
                ->with([
                    'documents',
                    'documentOutputs',
                    'user',
                    'transactions' => function ($q) {
                        $q->orderByDesc('id');
                    }
                ])
                ->latest()
                ->get();

            return response()->json(['data' => $reports]);
        }

        // Return error jika role tidak ditemukan
        return response()->json([
            'message' => 'Role tidak dikenali atau tidak berwenang.'
        ], 403);
    }

    /**
     * Semua role dapat memproses laporan berdasarkan peran dan status_ref.
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'file'  => 'nullable|file|max:2048',
            'target_user_id' => 'nullable|exists:user_tab,id' // untuk disposisi UKI
        ]);
    
        $user = Auth::user();
        $role = $user->role->title;
    
        DB::beginTransaction();
        try {
            $statusRef = null;
            $statusId = null;
            $notes    = $request->notes ?? '';
    
            if ($role === 'Petugas Layanan') {
                $statusRef = 2;
                $statusId  = $this->getStatusId('Diproses');
                $notes     = $notes ?: 'Diverifikasi oleh Petugas';
    
                // Aktifkan status_ref = 1 sebagai laporan masuk yang diverifikasi
                TReportTransactionTab::where('t_report_tab_id', $id)
                    ->where('status_ref', 1)
                    ->update(['status_active' => 1]);
    
                // Tambahkan transaksi baru status_ref = 2
                TReportTransactionTab::create([
                    't_report_tab_id' => $id,
                    'user_id'         => $user->id,
                    'status_ref'      => $statusRef,
                    'status_active'   => 1,
                    'm_status_tab_id' => $statusId,
                    'approve_dates'   => now(),
                    'notes'           => $notes,
                ]);
            }
    
            elseif ($role === 'Ketua UKI') {
                $statusRef = 3;
                $statusId  = $this->getStatusId('Diproses');
    
                TReportTransactionTab::create([
                    't_report_tab_id' => $id,
                    'user_id'         => $request->target_user_id,
                    'status_ref'      => $statusRef,
                    'status_active'   => 1,
                    'm_status_tab_id' => $statusId,
                    'approve_dates'   => now(),
                    'notes'           => 'Disposisi dari Ketua UKI ke Bidang',
                ]);
            }
    
            elseif ($role === 'Bidang/Satker/SNVT') {
                $statusRef = 4;
                $statusId  = $this->getStatusId('Diproses');
                $notes     = $notes ?: 'Sedang ditelaah oleh Bidang';
    
                if ($request->hasFile('file')) {
                    $request->file('file')->store('dokumen_telaah', 'public');
                }
    
                TReportTransactionTab::create([
                    't_report_tab_id' => $id,
                    'user_id'         => $user->id,
                    'status_ref'      => $statusRef,
                    'status_active'   => 1,
                    'm_status_tab_id' => $statusId,
                    'approve_dates'   => now(),
                    'notes'           => $notes,
                ]);
            }
    
            elseif ($role === 'Kepala BBWS') {
                $statusRef = 5;
                $statusId  = $this->getStatusId('Selesai');
                $notes     = $notes ?: 'Laporan selesai';

                if ($request->hasFile('file')) {
                    $path = $request->file('file')->store('dokumen_output', 'public');

                    TReportDocumentOutputTab::create([
                        't_report_tab_id' => $id,
                        'filename'        => $path,
                    ]);
                }

                // Tambahkan transaksi akhir
                TReportTransactionTab::create([
                    't_report_tab_id' => $id,
                    'user_id'         => $user->id,
                    'status_ref'      => $statusRef,
                    'status_active'   => 1,
                    'm_status_tab_id' => $statusId,
                    'approve_dates'   => now(),
                    'notes'           => $notes,
                ]);

                // Update transaksi awal (status_ref = 1) jadi status_id = 4 (selesai)
                TReportTransactionTab::where('t_report_tab_id', $id)
                    ->where('status_ref', 1)
                    ->update(['m_status_tab_id' => $statusId]);
            }
    
            else {
                return response()->json([
                    'message' => 'Role Anda tidak diizinkan memproses laporan ini.'
                ], 403);
            }
    
            DB::commit();
            return response()->json([
                'message' => 'Laporan berhasil diproses.'
            ]);
    
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'report' => 'required|string',
            'file'   => 'nullable|file|max:2048',
        ]);

        $user = Auth::user();

        $report = TReportTab::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Cek status transaksi awal apakah sudah aktif
        $initialTransaction = TReportTransactionTab::where('t_report_tab_id', $id)
            ->where('status_ref', 1)
            ->first();

        if (!$initialTransaction || $initialTransaction->status_active == 1) {
            return response()->json([
                'message' => 'Pengaduan sudah diproses dan tidak dapat diedit.'
            ], 403);
        }

        DB::beginTransaction();
        try {
            // Update isi pengaduan
            $report->update([
                'report' => $request->report,
            ]);

            // Update file jika ada
            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('dokumen_pengaduan', 'public');

                // Tambahkan dokumen baru
                TReportDocumentTab::create([
                    't_report_tab_id' => $report->id,
                    'filename'        => $path,
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Pengaduan berhasil diperbarui.'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateReport(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Cari laporan yang akan diupdate
            $report = TReportTab::findOrFail($id);

            // Jika ada file yang diupload
            if ($request->hasFile('document')) {
                // Hapus file lama (jika ada)
                if ($report->documents()->exists()) {
                    $oldFile = $report->documents->first();
                    if (Storage::exists($oldFile->filename)) {
                        Storage::delete($oldFile->filename);
                    }
                    $oldFile->delete(); // Menghapus file lama dari database
                }

                // Upload file baru
                $filePath = $request->file('document')->store('dokumen_pengaduan');
                // Simpan file baru ke database
                $report->documents()->create([
                    'filename' => $filePath
                ]);
            }

            // Update transaksi laporan dengan status baru
            $report->transactions()->create([
                'status_ref' => 2,  // Petugas Layanan sudah verifikasi
                'status_active' => 1,
                'm_status_tab_id' => 2,
                'notes' => 'Diverifikasi oleh Petugas',
                'approve_dates' => now(),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Laporan berhasil diperbarui',
                'data' => $report
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal memperbarui laporan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ambil ID dari m_status_tab berdasarkan title.
     */
    private function getStatusId(string $title): int
    {
        return MStatusTab::where('title', $title)->value('id');
    }

    /**
     * Menampilkan history laporan pengaduan berdasarkan peran (role) yang sudah diapprove.
     */
    public function history()
    {
        $user = Auth::user();  // Ambil data user yang login
        $role = $user->role->title;  // Ambil role user

        // Case 1: PETUGAS LAYANAN - Menampilkan laporan yang sudah di-approve oleh petugas layanan
        if ($role === 'Petugas Layanan') {
            $reports = TReportTab::with([
                    'transactions' => function ($q) {
                        $q->where('status_ref', 2)  // Status 2 berarti sudah diverifikasi oleh petugas
                        ->where('status_active', 1)  // Status aktif 1 berarti laporan sudah aktif
                        ->orderByDesc('id');  // Urutkan berdasarkan ID transaksi terbaru
                    },
                    'documents',
                    'documentOutputs'
                ])
                ->whereHas('transactions', function ($q) {
                    $q->where('status_ref', 2)  // Status 2 berarti sudah diverifikasi oleh petugas
                    ->where('status_active', 1);  // Status aktif 1 berarti laporan sudah aktif
                })
                ->get()
                ->map(function ($report) {
                    $transaction = $report->transactions->first();  // Ambil transaksi terakhir

                    return [
                        'id'                  => $report->id,
                        'user_id'             => $report->user_id,
                        'number_registration' => $report->number_registration,
                        'report'              => $report->report,
                        'status_active'       => $transaction->status_active ?? null,
                        'm_status_tab_id'     => $transaction->m_status_tab_id ?? null,
                        'notes'               => $transaction->notes ?? null,
                        'approve_dates'       => $transaction->approve_dates ?? null,
                        'created_at'          => $report->created_at,
                        'updated_at'          => $report->updated_at,
                        'documents'           => $report->documents,
                        'document_outputs'    => $report->documentOutputs,
                    ];
                });

            return response()->json(['data' => $reports]);
        }

        // Case 2: KETUA UKI - Menampilkan laporan yang sudah di-approve oleh ketua UKI
        if ($role === 'Ketua UKI') {
            $reports = TReportTab::with([
                    'transactions' => function ($q) {
                        $q->where('status_ref', 3)  // Status 3 berarti sudah diverifikasi oleh Ketua UKI
                        ->where('status_active', 1)  // Status aktif 1 berarti laporan sudah aktif
                        ->orderByDesc('id');
                    },
                    'documents',
                    'documentOutputs'
                ])
                ->whereHas('transactions', function ($q) {
                    $q->where('status_ref', 3)  // Status 3 berarti sudah diverifikasi oleh Ketua UKI
                    ->where('status_active', 1);  // Status aktif 1 berarti laporan sudah aktif
                })
                ->get()
                ->map(function ($report) {
                    $transaction = $report->transactions->first();  // Ambil transaksi terakhir

                    return [
                        'id'                  => $report->id,
                        'user_id'             => $report->user_id,
                        'number_registration' => $report->number_registration,
                        'report'              => $report->report,
                        'status_active'       => $transaction->status_active ?? null,
                        'm_status_tab_id'     => $transaction->m_status_tab_id ?? null,
                        'notes'               => $transaction->notes ?? null,
                        'approve_dates'       => $transaction->approve_dates ?? null,
                        'created_at'          => $report->created_at,
                        'updated_at'          => $report->updated_at,
                        'documents'           => $report->documents,
                        'document_outputs'    => $report->documentOutputs,
                    ];
                });

            return response()->json(['data' => $reports]);
        }

        // Case 3: BIDANG/SATKER/SNVT - Menampilkan laporan yang sudah di-approve oleh Ketua UKI
        if ($role === 'Bidang/Satker/SNVT') {
            $reports = TReportTab::with([
                    'transactions' => function ($q) {
                        $q->where('status_ref', 4)  // Status 4 berarti sudah ditelaah oleh Bidang/Satker/SNVT
                        ->where('status_active', 1)  // Status aktif 1 berarti laporan sudah aktif
                        ->orderByDesc('id');
                    },
                    'documents',
                    'documentOutputs'
                ])
                ->whereHas('transactions', function ($q) {
                    $q->where('status_ref', 4)  // Status 4 berarti sudah ditelaah oleh Bidang/Satker/SNVT
                    ->where('status_active', 1);  // Status aktif 1 berarti laporan sudah aktif
                })
                ->get()
                ->map(function ($report) {
                    $transaction = $report->transactions->first();  // Ambil transaksi terakhir

                    return [
                        'id'                  => $report->id,
                        'user_id'             => $report->user_id,
                        'number_registration' => $report->number_registration,
                        'report'              => $report->report,
                        'status_active'       => $transaction->status_active ?? null,
                        'm_status_tab_id'     => $transaction->m_status_tab_id ?? null,
                        'notes'               => $transaction->notes ?? null,
                        'approve_dates'       => $transaction->approve_dates ?? null,
                        'created_at'          => $report->created_at,
                        'updated_at'          => $report->updated_at,
                        'documents'           => $report->documents,
                        'document_outputs'    => $report->documentOutputs,
                    ];
                });

            return response()->json(['data' => $reports]);
        }

        // Case 4: KEPALA BBWS - Menampilkan laporan yang sudah di-approve oleh Bidang/Satker/SNVT
        if ($role === 'Kepala BBWS') {
            $reports = TReportTab::with([
                    'transactions' => function ($q) {
                        $q->where('status_ref', 5)  // Status 5 berarti laporan sudah selesai oleh Kepala BBWS
                        ->where('status_active', 1)  // Status aktif 1 berarti laporan sudah aktif
                        ->orderByDesc('id');
                    },
                    'documents',
                    'documentOutputs'
                ])
                ->whereHas('transactions', function ($q) {
                    $q->where('status_ref', 5)  // Status 5 berarti sudah selesai oleh Kepala BBWS
                    ->where('status_active', 1);  // Status aktif 1 berarti laporan sudah aktif
                })
                ->get()
                ->map(function ($report) {
                    $transaction = $report->transactions->first();  // Ambil transaksi terakhir

                    return [
                        'id'                  => $report->id,
                        'user_id'             => $report->user_id,
                        'number_registration' => $report->number_registration,
                        'report'              => $report->report,
                        'status_active'       => $transaction->status_active ?? null,
                        'm_status_tab_id'     => $transaction->m_status_tab_id ?? null,
                        'notes'               => $transaction->notes ?? null,
                        'approve_dates'       => $transaction->approve_dates ?? null,
                        'created_at'          => $report->created_at,
                        'updated_at'          => $report->updated_at,
                        'documents'           => $report->documents,
                        'document_outputs'    => $report->documentOutputs,
                    ];
                });

            return response()->json(['data' => $reports]);
        }

        return response()->json([
            'message' => 'Role tidak dikenali atau tidak berwenang.'
        ], 403);
    }

}
