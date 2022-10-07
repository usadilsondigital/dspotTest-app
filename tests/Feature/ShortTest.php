<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response_in_route_short()
    {
        $response = $this->get('/short');

        $response->assertStatus(200);
    }
    

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_redirect_in_route_shortest()
    {
        $response = $this->get('/shortest');
        $uri = "/short";
        $response->assertRedirect($uri);
      

    }

}
