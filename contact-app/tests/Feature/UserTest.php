<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\Response;

class UserTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_route_unauthorized_status() : void
    {
        $this->json('get', '/api/v1/contact')
         ->assertStatus(401);
    }

    public function test_create_user() : void
    {
        $this->markTestSkipped('must be revisited.');

        $test = [
            "name" => "new user 2",
            "email" => "muy@gmail.com",
            "password" => "abc123"
        ];

        $this->json('post', '/api/v1/user', $test)
         ->assertStatus(201);
    }

    public function test_route_login() : void
    {
        $fakeUser = ["email" => "invasor@gmail.com","password" => "abc123"];
        $this->json('post', '/api/v1/login', $fakeUser)->assertStatus(401);
        $trueUser = ["email" => "admin@gmail.com","password" => "abc123"];
        $this->json('post', '/api/v1/login', $trueUser)->assertStatus(200);
    }

}
