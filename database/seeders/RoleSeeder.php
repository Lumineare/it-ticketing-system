<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin (IT Staff)
        User::create([
            'name' => 'IT Admin',
            'email' => 'admin@it.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Akun User Biasa (Sesuai preferensimu: Username/Password saja, tapi Laravel butuh email unik, kita pakai email dummy jika mau strict username nanti bisa dimodifikasi)
        User::create([
            'name' => 'Jibril',
            'email' => 'jibril@company.com', 
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}