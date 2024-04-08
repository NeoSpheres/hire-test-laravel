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
    public function user_can_be_add(): void
    {
       $response = $this->post('users',[
          'label' => 'Un nouveau Utilisateur',
           'send_at ' => Carbon::tomorrow()

       ]);
        $response->assertOk();
        $this->assertCount(1,Order::all());
    }
}
