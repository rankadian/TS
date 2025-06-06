<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('profesi')->insert([
            [
                'nama_profesi' => 'Developer/Programmer/Software Engineer',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'IT Support/IT Administrator',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Infrastructure Engineer',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Digital Marketing Specialist',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Graphic Designer/Multimedia Designer',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Business Analyst',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'QA Engineer/Tester',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'IT Enterpreneur',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Trainer/Guru/Dosen (IT)',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Mahasiswa',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'nama_profesi' => 'Procurement & Operational Team',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Wirausahawan (Non IT)',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Trainer/Guru/Dosen (Non IT)',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_profesi' => 'Mahasiswa (Non IT)',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
