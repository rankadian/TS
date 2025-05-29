<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['role_id' => 1, 'role_code' => 'ADM', 'role_name' => 'Administrator'],
            ['role_id' => 2, 'role_code' => 'AMI', 'role_name' => 'Alumni'],
        ];
        DB::table('m_role')->insert($data);
    }
}
