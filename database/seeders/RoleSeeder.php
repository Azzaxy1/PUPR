<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_role_tab')->insert([
            ['title' => 'Pemohon', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Petugas Layanan', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Bidang/Satker/SNVT', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Ketua UKI', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Kepala BBWS', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
