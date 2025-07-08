<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_detail_tab')->insert([
            [
                'user_tab_id' => 1,
                'number_identification' => '3210012345678900',
                'number_phone' => '0811000001',
                'address' => 'Jl. Raya Pemohon No.1',
                'working' => 'Masyarakat',
                'address_office' => '-',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_tab_id' => 2,
                'number_identification' => '3210012345678901',
                'number_phone' => '0811000002',
                'address' => 'Jl. Kantor Layanan',
                'working' => 'Staff Pengelola',
                'address_office' => 'BBWS C3',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_tab_id' => 3,
                'number_identification' => '3210012345678902',
                'number_phone' => '0811000003',
                'address' => 'Jl. SNVT Tengah',
                'working' => 'Bidang Pengaduan',
                'address_office' => 'Satker Cidanau',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_tab_id' => 4,
                'number_identification' => '3210012345678903',
                'number_phone' => '0811000004',
                'address' => 'Jl. UKI Selatan',
                'working' => 'Ketua Tim UKI',
                'address_office' => 'Kantor BBWS',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_tab_id' => 5,
                'number_identification' => '3210012345678904',
                'number_phone' => '0811000005',
                'address' => 'Jl. Besar BBWS',
                'working' => 'Kepala BBWS',
                'address_office' => 'BBWS Cidanau Ciujung Cidurian',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
