<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::create([
            'name' => 'Teknisi 1',
            'email' => 'teknisi@admin.com',
            'role' => 'teknisi',
            'password' => bcrypt('password'),
        ]);
    }
}
