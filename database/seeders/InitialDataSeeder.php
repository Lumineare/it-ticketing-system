<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
public function run(): void
{
    // Buat beberapa Unit default
    $units = ['IT Support', 'HRD & Umum', 'Keuangan', 'Operasional', 'Marketing'];
    foreach ($units as $unit) {
        Unit::create(['name' => $unit]);
    }

        // Pastikan ada user dengan role 'admin' atau 'teknisi' jika belum ada
        if (!User::where('email', 'teknisi@it.com')->exists()) {
            User::create([
                'name' => 'Teknisi IT',
                'email' => 'teknisi@it.com',
                'password' => Hash::make('password'),
                'role' => 'admin', // Kita pakai role admin untuk teknisi
            ]);
        }
    }
}