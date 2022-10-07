<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AllFriendsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response_in_route_all_friends_of_a_profile()
    {
        $id = 1;
        $response = $this->get('/profiles/'.$id.'/friends');

        $response->assertStatus(200);
    }
}
