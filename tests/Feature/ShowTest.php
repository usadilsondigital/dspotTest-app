<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response_in_route_show()
    {
        $id = 1;
        $uri = '/api/profiles/'.$id;
        $response = $this->getJson($uri);
        $response->assertStatus(200);
    }
}
