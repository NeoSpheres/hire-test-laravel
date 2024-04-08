<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_if_user_is_created(): void
    {
        $userArray =[
            'name' => 'user_test1',
            'email' => 'user_test1@test.fr',
            'password' => '12345678'
        ];
        //dd($userArray);

        // Send a POST request to create the new player
        $response = $this->post('/user', $userArray);
        //dd($response);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'user_test1@test.fr']);
    }

    public function test_if_user_is_deleted(): void
    {
        $userArray =[
            'name' => 'user_test1',
            'email' => 'user_test1@test.fr',
            'password' => '12345678'
        ];
        //dd($userArray);


    }
}
