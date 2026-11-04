<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil AdminSeeder agar akun admin otomatis dibuat
        $this->call([
            AdminSeeder::class,
        ]);
    }
}