<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          User::firstOrCreate([
            'email' => 'admin@g.com',
        ],[
            'role' => User::ROLE_ADMIN,
            'name' => 'admin',
            'password' => Hash::make('admin')
        ]);

    }
}
