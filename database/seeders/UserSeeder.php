<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@role.test',
            'password' => bcrypt('123456789'),
        ]);

        $admin->assignRole('admin');


        $user = User::create([
            'name' => 'User',
            'email' => 'user@role.test',
            'password' => bcrypt('123456789'),
        ]);
    
        $user->assignRole('user');
    }
}
