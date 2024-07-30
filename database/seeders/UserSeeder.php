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
        // Create admin account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'roles' => 'admin',
        ]);

        // Create kasir account
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('12345678'),
            'roles' => 'kasir',
        ]);
    }
}
