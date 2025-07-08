<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_status_tab')->insert([
            ['title' => 'Menunggu Verifikasi', 'color' => '#ffc107', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Diproses', 'color' => '#17a2b8', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Ditolak', 'color' => '#dc3545', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Selesai', 'color' => '#28a745', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
