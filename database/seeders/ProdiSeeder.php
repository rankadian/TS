<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prodi')->insert([
            ['nama' => 'Teknik Informatika'],
            ['nama' => 'Sistem Informasi'],
            ['nama' => 'Manajemen'],
        ]);
    }
}
