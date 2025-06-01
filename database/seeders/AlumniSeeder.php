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
                'program_study' => 'Teknik Informatika',
                'year_graduated' => '29/09/2020',
                'name' => 'Budi Santoso',
                'no_hp' => '081234567890',
                'email' => 'budi.santoso@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'role_id' => 2, // sesuaikan jika ada role_id valid
                'nim' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_alumni')->insert($data);
    }
}
