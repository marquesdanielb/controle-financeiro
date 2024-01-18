<?php

use App\Models\User;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    //User::factory()->create(['email' => 'mail@mail.com']);
    return $router->app->version();
});

$router->post('/auth/{provider}', [
    'as' => 'authenticate', 
    'uses' => 'AuthController@postAuthenticate'
]);

$router->get('/users/me', [
    'as' => 'usersMe', 
    'uses' => 'MeController@getMe'
]);
