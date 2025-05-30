<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'admin_id' => 1,
                'role_id' => 1,
                'name' => 'admin 1',
                'email' => 'admin1@admin.polinema.ac.id',
                'password' => Hash::make('admin123'),

            ],
            [
                'admin_id' => 2,
                'role_id' => 1,
                'name' => 'admin 2',
                'email' => 'admin2@admin.polinema.ac.id',
                'password' => Hash::make('adminABC'),

            ],
            [
                'admin_id' => 3,
                'role_id' => 1,
                'name' => 'admin 3',
                'email' => 'admin3@admin.polinema.ac.id',
                'password' => Hash::make('adminadmin'),

            ],

        ];

        DB::table('m_admin')->insert($data);
    }
}
