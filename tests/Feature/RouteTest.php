<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_route_exists(): void
    {
        $response = $this->get('/api/v1/users');

        $response->assertStatus(200);
    }
}
