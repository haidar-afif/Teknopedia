<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // PASTIKAN BARIS INI ADA

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Admin Ensiklopedia',
            'email' => 'admin@web.com',
            'password' => Hash::make('password123'), // PAKSA HASH DI SINI
            'role' => 'admin',
        ]);

        // 2. Buat Daftar Kategori IT
        $categories = ['Web Development', 'Hardware & IoT', 'Version Control', 'Database'];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => strtolower(str_replace([' ', '&'], ['-', 'and'], $category))
            ]);
        }
    }
}
