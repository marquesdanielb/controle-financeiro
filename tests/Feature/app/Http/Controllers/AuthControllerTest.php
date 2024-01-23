<?php

namespace Feature\app\Http\Controllers;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function createApplication()
    {
        return require './bootstrap/app.php';
    }

    public function testUserShouldNotAuthenticateWithWrongProvider()
    {
        $payload = [
            'email' => 'mail@mail.com',
            'password' => 'admin',
        ];

        $request = $this->post(route('authenticate', ['provider' => 'datebayo']), $payload);

        $request->assertResponseStatus(422);
        $request->seeJson(['errors' => ['main' => 'Provider not found']]);
    }

    public function testUserShouldBeDeniedIfNotRegistered()
    {
        $payload = [
            'email' => 'naruto@mail.com',
            'password' => 'admin',
        ];

        $request = $this->post(route('authenticate', ['provider' => 'users']), $payload);
        $request->assertResponseStatus(401);
        $request->seeJson(['errors' => ['main' => 'Not authorized - Wrong credentials']]);
    }

    public function testUserShouldSendWrongPassword()
    {
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'userpassword',
        ];

        $request = $this->post(route('authenticate', ['provider' => 'users']), $payload);
        $request->assertResponseStatus(401);
        $request->seeJson(['errors' => ['main' => 'Not authorized - Wrong credentials']]);
    }

    public function testUserCanAuthenticate()
    {
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'admin',
        ];

        $request = $this->post(route('authenticate', ['provider' => 'users']), $payload);
        $request->assertResponseStatus(200);
        $request->seeJsonStructure(['access_token', 'expires_at', 'provider']);
    }
}
