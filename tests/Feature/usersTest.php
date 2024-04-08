<?php

namespace Tests\Feature;

use App\Models\post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class usersTest extends TestCase
{
    use RefreshDatabase;

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

   /* public function  test_user_insert(){
        User::Create([
            'name'=>'poip',
            'email'=> 'poipo@mail.fr',
            'password'=> 'jhgskgkj'
        ]);

        $response = $this->get('/user');
        dd(json_encode(json_decode($response->content()),JSON_PRETTY_PRINT));
       // $response->assertStatus(200);
       // $response->assertDontSee(__('No user found'));
       // $response->assertSee('User is here');

    }

   public function test_user_Factories()
    {
       // $users = User::factory(5)->create(); // with create we can make insertion in our databases based on our factory model
        $users = User::factory(5)->make(); //==> with make we can just create instances without make insertion in ou databases
        dd($users); // (dump and die) ==> it show if our users really be inserted in our databases
        $response=$this->get('/user'); // Method get to simul the navigation to the rout ('/user')
        $response->assertStatus(200); // verifie the response of our requettes
        $response->assertViewHas('users',function ($collection) use ($users){
           return !$collection->contains($users); //Vérifie que la vue retournée par la route contient une variable 'users' et que cette variable ne contient pas les utilisateurs générés précédemment.
        });
    }

    public function test_post_Factories()
    {
        //$posts = post::factory(5)->create(); // with create we can make insertion in our databases based on our factory model
            $posts = Post::factory(5)->make(); //==> with make we can just create instances without make insertion in ou databases
        dd($posts); // (dump and die) ==> it show if our users really be inserted in our databases
        //$response=$this->get('/user'); // Method get to simul the navigation to the rout ('/user')
        $response->assertStatus(200); // verifie the response of our requettes
        $response->assertViewHas('users',function ($collection) use ($posts){
            return !$collection->contains($posts); //Vérifie que la vue retournée par la route contient une variable 'users' et que cette variable ne contient pas les utilisateurs générés précédemment.
        });
    }*/
}
