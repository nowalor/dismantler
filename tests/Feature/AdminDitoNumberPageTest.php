<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminDitoNumberPageTest extends TestCase
{
    use RefreshDatabase;

    public function testNonAdminCannotAccessAdminDitoNumberPage()
    {
        $response = $this->get('/admin/dito-numbers');

        $response->assertRedirect('/login');
    }

    public function testAdminCanAccessDitoNumberPage()
    {
        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->get('/admin/dito-numbers');

        $response->assertStatus(200);
    }
}
