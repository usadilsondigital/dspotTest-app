<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

class ZTestEndPoints extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_json_route_api_index()
    {
        $response = $this->json('GET', '/api/profiles');
        $response->assertJsonStructure(
           [ '*' => [
                'id',
                'img',
                'first_name',
                'last_name',
                'phone',
                'address',
                'city',
                'state',
                'zipcode',
                'available',
                'created_at',
                'updated_at',
            ]]
        );
    }
   
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_json_route_api_show()
    {
        $id = 1;
        $response = $this->json('GET', '/api/profiles/' . $id);
        $response->assertJsonStructure([
            'id',
            'img',
            'first_name',
            'last_name',
            'phone',
            'address',
            'city',
            'state',
            'zipcode',
            'available',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_return_json_api_store(){
        $token = csrf_token();
        $headers = ['Authorization' => "$token"];
        $data = [
            'first_name'=> $this->getRandomWord(),
            'last_name'=> $this->getRandomWord(),
            'phone'=> 1234567890,
            'address'=> $this->getRandomWord(),
            'city'=> $this->getRandomWord(),
            'state'=> $this->getRandomWord(),
            'zipcode'=> 77777,
            'available'=> true
        ];
        $uri = '/api/profiles';           
        $response = $this->postJson($uri, $data, $headers);
        $response->assertJsonStructure([
            'id',
            'img',
            'first_name',
            'last_name',
            'phone',
            'address',
            'city',
            'state',
            'zipcode',
            'available',
            'created_at',
            'updated_at',
        ]);

    }

    function getRandomWord($len = 10) {
        $word = array_merge(range('a', 'z'), range('A', 'Z'));
        shuffle($word);
        return substr(implode($word), 0, $len);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_application_return_json_api_destroy(){
        $id=1;
        $uri = '/api/profile/'.$id.'/delete';           
        $response = $this->getJson($uri);
        $response->assertJsonStructure([
            'id',
            'img',
            'first_name',
            'last_name',
            'phone',
            'address',
            'city',
            'state',
            'zipcode',
            'available',
            'created_at',
            'updated_at',
        ]);

    }

}

