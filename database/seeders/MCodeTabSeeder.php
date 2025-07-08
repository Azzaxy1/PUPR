<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MCodeTabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_code_tab')->insert([
            'prefix' => 'REG-',             
            'start' => 1,                   
            'length' => 4,                  
            'year' => Carbon::now()->year, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
