<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function testHomepageReturns200()
    {
        $response = $this->get('');

        $response->assertStatus(200);
   }

    public function testSearchRedirectsToCarPartsPage()
    {
        $response = $this->get('');
    }
}
