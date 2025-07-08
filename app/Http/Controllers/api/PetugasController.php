<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TReportTab;
use App\Models\TReportTransactionTab;
use App\Models\TReportDocumentOutputTab;
use App\Models\TReportDocumentTab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    /**
     * Manage user: Update user information.
     */
    public function updateUser(Request $request, $id)
    {
        // Validasi hanya kolom yang diperbarui
        $rules = [
            'name'                  => 'nullable|string|max:255',
            'email'                 => 'nullable|string|email|max:255|unique:user_tab,email,' . $id,
            'role'                  => 'nullable|exists:m_role_tab,id',
            'number_identification' => 'nullable|string|max:255',
            'number_phone'          => 'nullable|string|max:255',
            'address'               => 'nullable|string|max:255',
            'working'               => 'nullable|string|max:255',
            'address_office'        => 'nullable|string|max:255',
            'password'              => 'nullable|string|min:6|confirmed',  // optional password field with confirmation
        ];

        // Validasi input
        $request->validate($rules);

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        DB::beginTransaction();
        try {
            // Data yang akan diupdate
            $dataToUpdate = [];

            // Update field yang ada di request
            if ($request->has('name')) {
                $dataToUpdate['name'] = $request->name;
            }
            if ($request->has('email')) {
                $dataToUpdate['email'] = $request->email;
            }
            if ($request->has('role')) {
                $dataToUpdate['m_role_tab_id'] = $request->role;
            }
            if ($request->has('password')) {
                $dataToUpdate['password'] = bcrypt($request->password);  // Hash password sebelum menyimpannya
            }

            // Update profil jika ada
            if ($request->has('number_identification')) {
                $dataToUpdate['number_identification'] = $request->number_identification;
            }
            if ($request->has('number_phone')) {
                $dataToUpdate['number_phone'] = $request->number_phone;
            }
            if ($request->has('address')) {
                $dataToUpdate['address'] = $request->address;
            }
            if ($request->has('working')) {
                $dataToUpdate['working'] = $request->working;
            }
            if ($request->has('address_office')) {
                $dataToUpdate['address_office'] = $request->address_office;
            }

            // Perbarui user hanya jika ada data yang ingin diubah
            if (!empty($dataToUpdate)) {
                $user->update($dataToUpdate);
            }

            // Jika ada data profile, update di tabel user_detail_tab
            if ($user->details) {
                $profileData = [];

                if ($request->has('number_identification')) {
                    $profileData['number_identification'] = $request->number_identification;
                }
                if ($request->has('number_phone')) {
                    $profileData['number_phone'] = $request->number_phone;
                }
                if ($request->has('address')) {
                    $profileData['address'] = $request->address;
                }
                if ($request->has('working')) {
                    $profileData['working'] = $request->working;
                }
                if ($request->has('address_office')) {
                    $profileData['address_office'] = $request->address_office;
                }

                if (!empty($profileData)) {
                    $user->details()->update($profileData);
                }
            }

            DB::commit();

            // Return the updated user data
            return response()->json([
                'message' => 'User berhasil diperbarui.',
                'data' => $user  // Return the updated user object
            ], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete user.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Final function to show the steps and date for completed reports.
     */
    public function final(Request $request)
    {
        try {
            $user = Auth::user();
            $role = $user->role->title;

            // Mengambil laporan pengaduan yang sudah selesai
            $reports = TReportTab::with([
                    'transactions' => function ($q) {
                        $q->orderBy('id', 'asc'); // Urutkan transaksi berdasarkan ID yang lebih kecil
                    },
                    'documents',
                    'documentOutputs',
                ])
                ->whereHas('transactions', function ($q) {
                    $q->where('status_ref', 5)  // Laporan sudah selesai
                    ->where('status_active', 1); // Status aktif
                })
                ->get()
                ->map(function ($report) {
                    $transactions = $report->transactions;

                    // Tahapan laporan pengaduan
                    $stages = [];

                    // Laporan Pengaduan
                    $stages[] = [
                        'tahapan' => 'Laporan Pengaduan',
                        'tanggal' => $report->created_at->toDateString(),
                        'keterangan' => $report->report,
                        'paraf' => 'Pemohon',
                    ];

                    // Verifikasi Kelengkapan Persyaratan oleh Petugas Layanan
                    $verificationTransaction = $transactions->firstWhere('status_ref', 2);
                    if ($verificationTransaction) {
                        $stages[] = [
                            'tahapan' => 'Verifikasi Kelengkapan Persyaratan',
                            'tanggal' => $verificationTransaction->approve_dates,
                            'keterangan' => $report->report,
                            'paraf' => 'Petugas Layanan',
                        ];
                    }

                    // Proses Penanganan Pengaduan oleh Ketua UKI
                    $processTransaction = $transactions->firstWhere('status_ref', 3);
                    if ($processTransaction) {
                        $stages[] = [
                            'tahapan' => 'Proses Penanganan Pengaduan',
                            'tanggal' => $processTransaction->approve_dates,
                            'keterangan' => $report->report,
                            'paraf' => 'Ketua UKI',
                        ];
                    }

                    // Konsep Telaah oleh Bidang/Satker/SNVT
                    $telaahTransaction = $transactions->firstWhere('status_ref', 4);
                    if ($telaahTransaction) {
                        $stages[] = [
                            'tahapan' => 'Konsep Telaah',
                            'tanggal' => $telaahTransaction->approve_dates,
                            'keterangan' => $report->report,
                            'paraf' => 'Bidang/Satker/SNVT',
                            'dokumen_telaah' => $report->documents->pluck('filename')->first(),
                        ];
                    }

                    // Jawaban Berdasarkan Hasil Telaah oleh Kepala BBWS
                    $finalTransaction = $transactions->firstWhere('status_ref', 5);
                    if ($finalTransaction) {
                        $stages[] = [
                            'tahapan' => 'Jawaban Berdasarkan Hasil Telaah',
                            'tanggal' => $finalTransaction->approve_dates,
                            'keterangan' => $report->report,
                            'paraf' => 'Kepala BBWS',
                            'dokumen_output' => $report->documentOutputs->pluck('filename')->first(),
                        ];
                    }

                    // Jawaban diterima pemohon
                    $stages[] = [
                        'tahapan' => 'Jawaban Diterima Pemohon',
                        'tanggal' => $finalTransaction ? $finalTransaction->approve_dates : 'N/A',
                        'keterangan' => $report->report,
                        'paraf' => 'Petugas Layanan',
                        'dokumen_akhir' => $finalTransaction ? $report->documentOutputs->pluck('filename')->first() : 'N/A',
                    ];

                    return [
                        'id'             => $report->id,
                        'number_registration' => $report->number_registration,
                        'stages'         => $stages
                    ];
                });

            return response()->json(['data' => $reports]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
