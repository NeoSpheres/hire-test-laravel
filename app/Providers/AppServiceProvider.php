<?php

namespace App\Providers;

use App\Listeners\UserCreatedListener;
use App\Services\Contracts\ITireMaintenanceService;
use App\Services\TireMaintenanceService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ITireMaintenanceService::class, TireMaintenanceService::class);
    }



    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(UserCreatedListener::class);

        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $settings = Setting::first();
            $view->with('settings', $settings);
        });
    }
    /* public function  test_user_insert(){
     User::Create([
         'name'=>'poip',
         'email'=> 'poipo@mail.fr',
         'password'=> 'jhgskgkj'
     ]);

     $response = $this->get('/user');
     dd(json_encode(json_decode($response->content()),JSON_PRETTY_PRINT)); // Where's your xDebug now? :D
    // $response->assertStatus(200);
    // $response->assertDontSee(__('No user found'));
    // $response->assertSee('User is here');

 }
*/
    /* public function test_user_Factories()
      {
         // $users = User::factory(5)->create(); // with create we can make insertion in our databases based on our factory model
          $users = User::factory(5)->make(); //==> with make we can just create instances without make insertion in ou databases
          dd($users); // (dump and die) ==> it show if our users really be inserted in our databases
          $response=$this->get('/user'); // Method get to simul the navigation to the rout ('/user')
          $response->assertStatus(200); // verifie the response of our requettes
          $response->assertViewHas('users',function ($collection) use ($users){
             return !$collection->contains($users); //Vérifie que la vue retournée par la route contient une variable 'users' et que cette variable ne contient pas les utilisateurs générés précédemment.
          });
      }*/
    /*
        public function test_post_Factories()
        {
            //$posts = post::factory(5)->create(); // with create we can make insertion in our databases based on our factory model
                $posts = Post::factory(5)->make(); //==> with make we can just create instances without make insertion in ou databases
            dd($posts); // (dump and die) ==> it show if our users really be inserted in our databases + dd() for the win :D
            //$response=$this->get('/user'); // Method get to simul the navigation to the rout ('/user')
            $response->assertStatus(200); // verifie the response of our requettes
            $response->assertViewHas('users',function ($collection) use ($posts){
                return !$collection->contains($posts); //Vérifie que la vue retournée par la route contient une variable 'users' et que cette variable ne contient pas les utilisateurs générés précédemment.
            });
        }*/


}
