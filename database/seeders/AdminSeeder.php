<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    User::create([
        'name' => 'admin1',
        'email' => 'admin1@example.com',
        'password' => Hash::make('password123'),
        'role' => 'admin',
    ]);
}
}
