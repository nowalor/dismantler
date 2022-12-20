<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminKbaPageTest extends TestCase
{
    use RefreshDatabase;

    public function testNonAdminCannotAccessAdminKbaPage()
    {
        $response = $this->get('/admin/kba');

        $response->assertRedirect('/login');
    }

    public function testAdminCanAccessKbaPage()
    {
        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->get('/admin/kba');

        $response->assertStatus(200);
    }
}
