<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_tab')->insert([
            [
                'name' => 'Pemohon User',
                'email' => 'pemohon@example.com',
                'password' => Hash::make('password'),
                'm_role_tab_id' => 1, // Pemohon
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Petugas Layanan',
                'email' => 'petugas@example.com',
                'password' => Hash::make('password'),
                'm_role_tab_id' => 2, // Petugas Layanan
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bidang SNVT',
                'email' => 'bidang@example.com',
                'password' => Hash::make('password'),
                'm_role_tab_id' => 3, // Bidang/Satker/SNVT
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ketua UKI',
                'email' => 'ketuauki@example.com',
                'password' => Hash::make('password'),
                'm_role_tab_id' => 4, // Ketua UKI
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kepala BBWS',
                'email' => 'kepalabbws@example.com',
                'password' => Hash::make('password'),
                'm_role_tab_id' => 5, // Kepala BBWS
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
