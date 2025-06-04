<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'program_study' => 'Sistem Informasi Bisnis',
                'year_graduated' => '2004-09-29',
                'name' => 'Evan Diantha Fafian',
                'nim' => '2341760163',
                'no_hp' => '087850352168',
                'email' => '2341760163@student.polinema.ac.id',
                'email_verified_at' => now(),
                'password' => Hash::make(2341760163),
                'remember_token' => Str::random(10),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_alumni')->insert($data);
    }
}
