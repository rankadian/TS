<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alumni')->insert([
            'user_id' => 2,
            'prodi_id' => 1,
            'nim' => '12345678',
            'nama' => 'Budi',
            'tahun_lulus' => 2022,
            'tanggal_lulus' => '2022-08-15',
            'no_hp' => '081234567891',
            'email' => 'budi@example.com',
        ]);
    }
}
