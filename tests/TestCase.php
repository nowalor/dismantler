<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createRegularUser()
    {

    }

    public function createAdminUser(): User
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('@Password091'),
            'email_verified_at' => now(),
            'is_admin' => TRUE,
        ]);

        return $user;
    }
}
