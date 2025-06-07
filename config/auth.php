<?php

return [

    'defaults' => [
        'guard' => 'web', // Default guard tetap 'web'
        'passwords' => 'users', // Sesuai dengan provider 'users' di bawah
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],
        'alumni' => [
            'driver' => 'session',
            'provider' => 'alumni',
        ],
    ],

    'providers' => [
        'users' => [ // Tambahkan provider 'users' agar default 'web' tidak error
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Models\AdminModel::class,
        ],
        'alumni' => [
            'driver' => 'eloquent',
            'model' => App\Models\AlumniModel::class,
        ],
    ],

    'passwords' => [
        'users' => [ // Default reset password untuk semua user
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [ // Optional: jika kamu ingin reset password khusus admin
            'provider' => 'admin',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'alumni' => [ // Optional: reset password untuk alumni
            'provider' => 'alumni',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
