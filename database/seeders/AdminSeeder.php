<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tiket.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // User Pembeli
        User::create([
            'name' => 'Pembeli',
            'email' => 'pembeli@tiket.com',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);

        // Creator
        User::create([
            'name' => 'Creator',
            'email' => 'creator@tiket.com',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);
    }
}
