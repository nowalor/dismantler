<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed one Admin user
        User::create([
            'name' => 'Admin',
            'email' => '',
            'password' => Hash::make(''), // do we add all seeders to the .gitignore file or?
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);
    }
}
