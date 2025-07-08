<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    /**
     * Generate a new report code.
     * Format: {prefix}{year}{sequence}
     */
    public function generateReportCode()
    {
        $mCodeTab = DB::table('m_code_tab')->first();

        if (!$mCodeTab) {
            abort(500, 'Kode tidak ditemukan di tabel m_code_tab.');
        }

        $currentYear = now()->year;

        // Reset jika tahun telah berubah
        if ($mCodeTab->year != $currentYear) {
            DB::table('m_code_tab')->update([
                'start' => 1,
                'year' => $currentYear,
            ]);
        } else {
            DB::table('m_code_tab')->increment('start');
        }

        // Format nomor registrasi
        $nextNumber = str_pad($mCodeTab->start, $mCodeTab->length, '0', STR_PAD_LEFT);
        return "{$mCodeTab->prefix}{$currentYear}{$nextNumber}";
    }
}
