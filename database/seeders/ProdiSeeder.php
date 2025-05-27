<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prodi')->insert([
            ['nama' => 'D4 TI'],
            ['nama' => 'D4 SIB'],
            ['nama' => 'D2 PPLS'],
            ['nama' => 'S2 MRTI']
            
        ]);
    }
}
