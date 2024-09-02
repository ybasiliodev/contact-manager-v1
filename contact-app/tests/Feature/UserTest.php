<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\Response;

class UserTest extends TestCase
{
    public function test_route_unauthorized_status() : void
    {
        $this->json('get', '/api/v1/contact/list')
         ->assertStatus(401);
    }

    public function test_create_user() : void
    {
        $newUser = ["name" => "new user","email" => "novo_user@gmail.com","password" => "abc123"];
        $this->json('post', '/api/v1/user', $newUser)->assertStatus(201);
    }

    public function test_route_login() : void
    {
        $fakeUser = ["email" => "invasor@gmail.com","password" => "abc123"];
        $this->json('post', '/api/v1/login', $fakeUser)->assertStatus(401);
        $trueUser = ["email" => "novo_user@gmail.com","password" => "abc123"];
        $this->json('post', '/api/v1/login', $trueUser)->assertStatus(200);
    }

    public function test_login() : void
    {
        $newUser = ["email" => "novo_user@gmail.com","password" => "abc123"];
        $response = $this->json('post', '/api/v1/login', $newUser);
        $response->assertStatus(200)->assertJson(['token_type' => 'bearer']);
        $token = $response['access_token'];
        $response = $this->withHeaders(['Authorization'=>'Bearer '.$token])->get('/api/v1/contact/list?perPage=10');
        $response->assertStatus(200);
    }

    public function test_login_and_delete() : void
    {
        $newUser = ["email" => "novo_user@gmail.com","password" => "abc123"];
        $response = $this->json('post', '/api/v1/login', $newUser);
        $response->assertStatus(200)->assertJson(['token_type' => 'bearer']);
        $token = $response['access_token'];
        $test = $this->withHeaders(['Authorization'=>'Bearer '.$token])->delete('/api/v1/user', ["password" => "abc123"]);
        $test->assertStatus(204);
    }

}
