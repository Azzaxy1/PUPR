<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CodeController extends Controller
{
    // Generate kode unik untuk laporan
    public static function generateReportCode()
    {
        $mCode = DB::table('m_code_tab')->first();
        if (! $mCode) {
            abort(500, 'Kode tidak ditemukan di tabel m_code_tab.');
        }

        $currentYear = now()->year;

        // HITUNG COUNTER BARU
        if ($mCode->year != $currentYear) {
            $nextCounter = 1;
        } else {
            $nextCounter = $mCode->start + 1;
        }

        // UPDATE TABEL DENGAN COUNTER DAN TAHUN
        DB::table('m_code_tab')->update([
            'start' => $nextCounter,
            'year'  => $currentYear,
        ]);

        // FORMAT DENGAN ZERO-PAD
        $sequence = str_pad($nextCounter, $mCode->length, '0', STR_PAD_LEFT);

        return $mCode->prefix . $currentYear . $sequence;
    }
}
