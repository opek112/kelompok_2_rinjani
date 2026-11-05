<?php

namespace Database\Seeders;

use Modules\Identity\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Rizki Aditya',
            'email' => 'admin@rinjaniguide.com',
            'no_telepon' => '081234567890',
            'password' => Hash::make('password123'), // Passwordnya: password123
            'peran' => 'admin', // Ini kunci utamanya!
        ]);
    }
}
