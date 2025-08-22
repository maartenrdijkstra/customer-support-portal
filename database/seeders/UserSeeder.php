<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
     {
        // Admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'maartenrdijkstra@gmail.com',
            'is_admin' => true,
            'password' => Hash::make('pw'),
        ]);

        // Test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'elcilor@gmail.com',
            'is_admin' => false,
            'password' => Hash::make('pw123'),
        ]);
    }
}
