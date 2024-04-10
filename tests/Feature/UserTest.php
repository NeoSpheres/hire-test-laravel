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
    use RefreshDatabase;

    public function test_user_creation()
    {
        // Créer un utilisateur via le CRUD
        $user = User::factory()->create();

        // Vérifier si l'utilisateur a une voiture associée
        $this->assertNotNull($user->car);
    }


}
