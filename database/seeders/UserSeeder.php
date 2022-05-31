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
            'name' => 'Nikulás Óskarsson',
            'email' => 'nikulsaoskarsson@gmail.com',
            'password' => Hash::make('@Password091'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);
    }
}
