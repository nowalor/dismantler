<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminOrdertPageTest extends TestCase
{
    public function testNonAdminCannotAccessAdminDitoNumberPage()
    {
        $response = $this->get('/admin/orders');

        $response->assertRedirect('/login');
    }

    public function testAdminCanAccessDitoNumberPage()
    {
        $user = $this->createAdminUser();

        $response = $this->actingAs($user)->get('/admin/orders');

        $response->assertStatus(200);
    }

    public function testAdminCanMarkProductAsDelivered()
    {
        /* $user = $this->createAdminUser();

        $response = $this->actingAs($user)->get('/admin/orders'); */
    }
}
